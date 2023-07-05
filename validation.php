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
    <style>
        body {
            align-items: center;
        }
    </style>
</head>

<body>
    <?php
    include_once "logic/SQLUserDAO.php";
    include_once "logic/essentials/Database.php";
    include_once "logic/UserManagement.php";

    $db = Database::getInstance();
    $conn = $db->getDatabase();
    $userDAO = new SQLUserDAO($conn);
    $user = $userDAO->get(unserialize($_SESSION["user"])->email);
    ?>

    <?php
    if (isset($user)): ?>
        <a href="anmeldung.php">
            <button class="accent">
                Anmelden
            </button>
        </a>
    <?php else: ?>
        <form action="logic/UserManagement.php" method="post"></form>
        <input type="hidden" name="valid">
        <button type="submit" class="accent"> Registrieren</button>
        </form>
    <?php endif ?>
</body>

</html>