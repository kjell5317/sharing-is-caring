<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anmelden</title>
</head>
<body>
    <?php include "components/header.php"; ?>

    <form action="anmeldung.php">
        <label for="email">E-Mail Adresse</label>
        <br>
        <input type="text" id="email" name="email" required>
        <br>

        <label for="password">Passwort</label>
        <br>
        <input type="password" id="password" name="password" required>
        <br>

        <input type="submit" value="Anmelden">
    </form>

    <?php include "components/footer.php"; ?>
</body>
</html>