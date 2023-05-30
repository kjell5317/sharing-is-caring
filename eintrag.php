<?php include "logic/Card.php" ;
   $card = Card::getCardWithoutOwner("Halber Döner","veggi","26-03-2024","Oldenburg","26129","assets/lecker.jpg","Leckerer Döner, bisschen ranzig aber in Ordnung");
?>
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
    <?php include "components/header.php"; ?>
    <main>
      <h1><?= $card->getTitle()?></h1>
      <div class="details">
        <ul>
          <li class="child">
            <div class="mini-text">
              <img src="assets/calendar.svg" class="mini" />
              <p><?= $card->getExpirationDate() ?></p>
            </div>
          </li>
          <li class="child">
            <p><?= $card->getFoodType()?></p>
          </li>
          <li class="child">
            <div class="mini-text">
              <img src="assets/mark.svg" class="mini" />
              <p><?= $card->getPostalCode() . " " . $card->getPlace()?> </p>
            </div>
          </li>
        </ul>
      </div>
      <br />
      <form class="eintrag" action="meine-einträge.php">
        <div class="form-section">
          <label>Beschreibung</label>
          <textarea class="desc-text" readonly rows="8">
            <?= $card->getDescription()?></textarea
          >
          <button class="submit" type="submit">Will ich haben! </button>
        </div>
        <div class="image-container">
          <img
            class="food-img-dsp"
            src=<?= $card->getImagePath() ?>
            alt="Beispielbild"
          />
        </div>
      </form>
    </main>
    <?php include "components/footer.php"; ?>
  </body>
</html>
