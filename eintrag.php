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
      <h1>Halber Döner</h1>
      <div class="details">
        <ul>
          <li class="child">
            <div class="mini-text">
              <img src="assets/calendar.svg" class="mini" />
              <p>05.05.23</p>
            </div>
          </li>
          <li class="child">
            <p>Vegan</p>
          </li>
          <li class="child">
            <div class="mini-text">
              <img src="assets/mark.svg" class="mini" />
              <p>26197 Huntlosen</p>
            </div>
          </li>
        </ul>
      </div>
      <br />
      <form class="eintrag" action="meine-einträge.php">
        <div class="form-section">
          <label>Beschreibung</label>
          <textarea class="desc-text" readonly rows="8">
Hier könnte ihre Werbung stehen</textarea
          >
          <button class="submit" type="submit">Will ich haben!</button>
        </div>
        <div class="image-container">
          <img
            class="food-img-dsp"
            src="assets/lecker.jpg"
            alt="Beispielbild"
          />
        </div>
      </form>
    </main>
    <?php include "components/footer.php"; ?>
  </body>
</html>
