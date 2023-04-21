<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neuer Eintrag</title>
</head>
<body>
    <?php include "components/header.php"; ?>

    <form action="meine-einträge.php">
        <label for="title">Titel</label>
        <input type="text" id="title" name="title" required>

        <label for="image">Bild</label>
        <input type="file" id="image" name="image" accept="image/png, image/jpeg">

        <label for="essen">Essensart</label>
        <select name="essen" id="essen" required>
            <option value="vegan">Vegan</option>
            <option value="veggi">Vegetarisch</option>
            <option value="schwein">Schwein</option>
            <option value="rind">Rind</option>
            <option value="sonst">Anderes</option>
        </select>

        <label for="mhd">Mindestens haltbar bis</label>
        <input type="date" id="mhd" name="mhd" required>

        <label for="str">Straße</label>
        <input type="text" id="str" name="str" required>
        <label for="hn">Hausnummer</label>
        <input type="number" id="hn" name="hn" required>
        <label for="plz">Postleitzahl</label>
        <input type="number" id="plz" name="plz" required>

        <label for="desc">Beschreibung</label>
        <input type="text" id="desc" name="desc">

        <label for="tel">Telefonnummer</label>
        <input type="number" id="tel" name="tel">

        <input type="submit" value="Bestätigen">
    </form>

    <?php include "components/footer.php"; ?>
</body>
</html>