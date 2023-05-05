<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/global.css" />
    <title>Neuer Eintrag</title>
  </head>
  <body>
    <?php include "components/header.php"; ?>
    <main>
      <form action="meine-einträge.php">
        <label for="title">Titel</label>
        <br />
        <input type="text" id="title" name="title" required />
        <br />

        <label for="image">Bild</label>
        <br />
        <input
          type="file"
          id="image"
          name="image"
          accept="image/png, image/jpeg"
        />
        <br />

        <label for="essen">Essensart</label>
        <br />
        <select name="essen" id="essen" required>
          <option value="vegan">Vegan</option>
          <option value="veggi">Vegetarisch</option>
          <option value="schwein">Schwein</option>
          <option value="rind">Rind</option>
          <option value="sonst">Anderes</option>
        </select>
        <br />

        <label for="mhd">Mindestens haltbar bis</label>
        <br />
        <input type="date" id="mhd" name="mhd" required />
        <br />

        <label for="str">Straße</label>
        <br />
        <input type="text" id="str" name="str" required />
        <br />
        <label for="hn">Hausnummer</label>
        <br />
        <input type="number" id="hn" name="hn" required />
        <br />
        <label for="plz">Postleitzahl</label>
        <br />
        <input type="number" id="plz" name="plz" required />
        <br />

        <label for="desc">Beschreibung</label>
        <br />
        <input type="text" id="desc" name="desc" />
        <br />

        <label for="tel">Telefonnummer</label>
        <br />
        <input type="number" id="tel" name="tel" />
        <br />

        <input type="submit" value="Bestätigen" />
      </form>
    </main>
    <?php include "components/footer.php"; ?>
  </body>
</html>
