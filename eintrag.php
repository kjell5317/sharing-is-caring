<!DOCTYPE html>
<html lang="de">

<?php
include_once "logic/SessionCardDAO.php";
include_once "logic/CardManager.php";

if (isset($_GET['id'])) {
  $cardmanager = new SessionCardDAO();
  $card = $cardmanager->loadCard($_GET['id']);
}
?>

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/eintrag.css" />
  <link rel="stylesheet" href="css/global.css" />
  <link rel="icon" type="image/svg" href="assets/favicon.svg" />
  <title>Eintrag</title>
</head>

<body>
  <?php include "components/header.php"; ?>
  <main>
    <h1>
      <?= $card->title ?>
    </h1>
    <div class="details">
      <ul>
        <li class="child">
          <div class="mini-text">
            <img src="assets/calendar.svg" class="mini" />
            <p>
              <?= $card->expirationDate ?>
            </p>
          </div>
        </li>
        <li class="child">
          <p>
            <?= $card->foodType ?>
          </p>
        </li>
        <li class="child">
          <div class="mini-text">
            <img src="assets/mark.svg" class="mini" />
            <p>
              <?= $card->postalCode . " " . $card->place ?>
            </p>
          </div>
        </li>
      </ul>
    </div>
    <br />
    <form class="eintrag" method="post">
      <div class="form-section">
        <label>Beschreibung</label>
        <textarea class="desc-text" readonly rows="8">
            <?= $card->description ?></textarea>
        <?php if (isset($_SESSION['claimedCards'][$_SESSION['loggedInUser']][$_GET['id']])): ?>
          <input type="hidden" name="unclaim"/>
          <button class="accent" type="submit">Will ich nicht mehr!</button>
      <?php else: ?>
        <input type="hidden" name="claim"/>
        <button class="accent" type="submit">Will ich haben!</button>
      <?php endif; ?>
        
      </div>
      <div class="image-container">
        <img class="food-img-dsp" src=<?= $card->imagePath ?> alt="Beispielbild" />
      </div>
    </form>
  </main>
  <?php include "components/footer.php"; ?>
</body>

</html>