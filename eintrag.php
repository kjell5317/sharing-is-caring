<!DOCTYPE html>
<html lang="de">

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
  <?php include "components/header.php";
  include_once "logic/sqlDAO/SQLCardDAO.php";
  include_once "logic/sqlDAO/SQLAddressDAO.php";
  include_once "logic/card/CardManager.php";

  if (isset($_GET['id'])) {
    $cardmanager = new SQLCardDAO();
    $addressmanager = new SQLAddressDAO();
    $card = $cardmanager->loadCard($_GET['id']);
  }
  if (!isset($card)) {
    header("Location: index.php");
    exit;
  }
  ?>
  <main>
    <h1>
      <?= htmlentities($card->title) ?>
    </h1>
    <div class="details">
      <ul>
        <li class="child">
          <div class="mini-text">
            <img src="assets/calendar.svg" class="mini" />
            <p>
              <?= htmlentities($card->expirationDate) ?>
            </p>
          </div>
        </li>
        <li class="child">
          <p>
            <?= htmlentities($card->foodType) ?>
          </p>
        </li>
        <li class="child">
          <div class="mini-text">
            <img src="assets/mark.svg" class="mini" />
            <p>
              <?php
              $address = $addressmanager->get($card->adr_id);
              $first = $address->street . ' ' .
                $address->number;
              $second = $address->postalCode . ' ' .
                $address->city;
              if (isset($_SESSION["url"])) {
                $result = file_get_contents($_SESSION["url"] . urlencode($first . ' ' . $second));
                if ($result !== false) {
                  $v = json_decode($result)->rows[0]->elements[0]->distance->text;
                }
              }
              $addressprefix = "";
              if (isset($_SESSION['loggedInUser']) && $card->claimer == unserialize($_SESSION['loggedInUser'])->id) {
                $addressprefix = $first . ", ";
              }
              if (isset($v)) {
                echo htmlentities($addressprefix . $second . " (" . $v . ")");
              } else {
                echo htmlentities($addressprefix . $second);
              }
              ?>
            </p>
          </div>
        </li>
      </ul>
    </div>
    <form class="eintrag" method="POST">
      <div class="img-container">
        <img class="food-img-dsp" src=<?= $card->imagePath ?> alt="Beispielbild"
        onerror="this.onerror=null; this.src='assets/nopic.png';" />
      </div>
      <div class="desc-container">
        <label>Beschreibung</label>
        <textarea class="desc-text" readonly rows="8">
            <?= $card->description ?></textarea>
        <?php if (isset($_SESSION['loggedInUser']) && $card->owner == unserialize($_SESSION['loggedInUser'])->id): ?>
          <input type="hidden" name="securityToken" value="<?php echo getCSRFToken(); ?>">
          <input type="hidden" name="delete" />
          <button class="accent-delete" type="submit">Eintrag löschen</button>
          <?php else: ?>
          <?php if (isset($_SESSION['loggedInUser']) && $card->claimer == unserialize($_SESSION['loggedInUser'])->id): ?>
            <input type="hidden" name="securityToken" value="<?php echo getCSRFToken(); ?>">
            <input type="hidden" name="unclaim" />
            <button class="accent" type="submit">Will ich nicht mehr!</button>
          <?php else: ?>
            <input type="hidden" name="securityToken" value="<?php echo getCSRFToken(); ?>">
            <input type="hidden" name="claim" />
            <button class="accent" type="submit">Will ich haben!</button>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </form>
  </main>
  <?php include "components/footer.php"; ?>
</body>

</html>