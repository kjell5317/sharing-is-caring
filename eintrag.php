<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/global.css" />
    <title>Eintrag</title>
  </head>
  <body>
    <?php include "components/header.php"; ?>
    <main>
      <form action="meine-einträge.php">
        <h1>Titel</h1>
        <img src="" alt="Bild" />
        <br />
        Essensart
        <br />
        Mindestens haltbar bis
        <br />
        Straße Hausnummer
        <br />
        Postleitzahl
        <br />
        Beschreibung
        <br />
        Telefonnummer
        <br />
        <input type="submit" value="Abholen" />
      </form>
    </main>
    <?php include "components/footer.php"; ?>
  </body>
</html>
