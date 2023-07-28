<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/global.css" />
    <link rel="icon" type="image/svg" href="assets/favicon.svg">
    <title>Validierung</title>
    <link rel="stylesheet" type="text/css" href="css/global.css" />
    <link rel="stylesheet" type="text/css" href="css/anmeldung.css" />
    <style>
        body {
            align-items: center;
        }
    </style>
</head>

<body>
    <main>
        <?php
        include_once "logic/sqlDAO/SQLUserDAO.php";
        include_once "logic/user/UserManagement.php";

        $userDAO = new SQLUserDAO();
        $user = $userDAO->get(unserialize($_SESSION["user"])->email);
        ?>

        <?php
        if (unserialize($_SESSION["user"])->validated == 1): ?>
            <!--             <input type="hidden" name="valid">
 -->
            <h1>Du hast bereits ein Konto!</h1>
            <h3>Bitte ignoriere diese E-Mail, wenn du nicht versucht hast dich bei uns zu registrieren.<br>Du hast bereits
                ein Konto bei uns und kannst dich hier anmelden:</h3>
            <a href='anmeldung.php'>JETZT ANMELDEN</a>
            </a>
        <?php else: ?>
            <!--             <input type="hidden" name="valid">
 -->
            <h1>Danke für deine Registrierung!</h1>
            <h3>Bitte ignoriere diese E-Mail, wenn du nicht versucht hast dich bei uns zu registrieren.<br>Solltest du es
                gewesen sein, klicke auf folgenden Link, um die Registrierung abzuschließen:</h3>
            <a href="registrierung.php?validate=<?= htmlentities(unserialize($_SESSION["user"])->id) ?>">REGISTRIERUNG
                ABSCHLIEßEN</a>
        <?php endif ?>
    </main>
</body>

</html>