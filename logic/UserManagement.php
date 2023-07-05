<?php
include_once "SQLUserDAO.php";
include_once "essentials/Database.php";

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$db = Database::getInstance();
$conn = $db->getDatabase();
$userDAO = new SQLUserDAO($conn);

if (isset($_GET['validate'])) {
    $response = $userDAO->validate(htmlentities($_GET['validate']));
    $_SESSION['info'] = 'Dein Konto wurde bestätigt! Du kannst dich nun einloggen.';

    // Umleitung zur Anmeldung
    header("Location: anmeldung.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /*
     * Anfrage ist eine Registrierung
     */
    if (isset($_POST['register'])) {
        if(isset($_POST['TOS'])) {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $repassword = $_POST['repassword'] ?? '';
            $_SESSION['email'] = $email;

            if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($password) && !empty($repassword)) {
                if ($password !== $repassword) {
                    $_SESSION['error'] = 'Die Passwörter stimmen nicht überein!';

                    // Umleitung zur Registrierungsseite
                    header("Location: registrierung.php");
                    exit;
                }
                $password = password_hash($password, PASSWORD_DEFAULT);
                $response = $userDAO->createUser($email, $password);
                $_SESSION["info"] = "Wir haben dir eine<a href='validation.php' target='_blank'>BESTÄTIGUNGS-E-MAIL</a>gesendet!";
                header("Location: registrierung.php");
                exit;
            } else {
            $_SESSION['error'] = 'Bitte gültige E-Mail und Passwort eingeben!';
            // Umleitung zur Registrierungsseite
            header("Location: registrierung.php");
            exit; 
            }
        } else {
            $_SESSION['error'] = 'Bitte akzeptiere die Nutzungsbedingungen und Datenschutzerklärung!';

            // Umleitung zur Registrierungsseite
            header("Location: registrierung.php");
            exit;
        }
    }

    if (isset($_POST['valid'])) {
        $user = unserialize($_SESSION["user"]);
        $response = $userDAO->createUser($user->email, $user->password);
        if ($response) {
            $_SESSION['info'] = 'Du wurdest erfolgreich registriert! Viel Spaß beim teilen.';
            // Umleitung zur Startseite
            header("refresh:1;url=index.php");
        }
    }

    /*
     * Anfrage ist ein Login
     */
    if (isset($_POST['login'])) {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $_SESSION['email'] = $email;

        $user = $userDAO->get($email);
        if (isset($user)) {
            if (password_verify($password, $user->password)) {
                $response = $userDAO->login($user);

                if ($response) {
                    $_SESSION['info'] = 'Du wurdest erfolgreich eingeloggt! Viel Spaß beim teilen.';

                    // Umleitung zur Startseite
                    header("refresh:1;url=index.php");
                } else {
                    $_SESSION['error'] = 'Hier ist etwas schief gelaufen... Versuche es bitte nochmal!';

                    // Umleitung zur Registrierungsseite
                    header("Location: anmeldung.php");
                    exit;
                }
            } else {
                $_SESSION['error'] = 'Bitte gültige E-Mail und Passwort eingeben';

                // Umleitung zur Loginseite
                header("Location: anmeldung.php");
                exit;
            }
        } else {
            $_SESSION['error'] = 'Bitte gültige E-Mail und Passwort eingeben';

            // Umleitung zur Loginseite
            header("Location: anmeldung.php");
            exit;
        }
    }
    
    if (isset($_POST['latitude']) && isset($_POST['longitude']) && !empty($_POST['latitude']) && !empty($_POST['longitude'])) {
        $_SESSION["url"] = "https://maps.googleapis.com/maps/api/distancematrix/json?destinations=" . trim($_POST['latitude']) . "%2C" . $_POST['longitude'] . "&key=AIzaSyDZq_kAv-S0HJKr1pER7CPfqqxnNpWy63M&origins=";
    }
}


if (isset($_GET['logout'])) {
    $response = $userDAO->logout();

    if ($response) {
        $_SESSION['info'] = 'Du wurdest erfolgreich ausgeloggt! Bis zum nächsten mal.';

        // Umleitung zur Startseite
        header("Location: index.php");
    } else {
        $_SESSION['error'] = 'Hier ist etwas schief gelaufen... Versuche es bitte nochmal!';
        exit;
    }
}

$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);

$info = $_SESSION['info'] ?? '';
unset($_SESSION['info']);

?>