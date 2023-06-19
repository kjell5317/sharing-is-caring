<?php
include_once "SQLUserDAO.php";
include_once "Database.php";

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$db = Database::getInstance();
$conn = $db->getDatabase();
$userDAO = new SQLUserDAO($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /*
     * Anfrage ist eine Registrierung
     */
    if (isset($_POST['register'])) {
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

            if ($response) {
                $_SESSION['info'] = 'Du wurdest erfolgreich registriert! Viel Spaß beim teilen.';

                // Umleitung zur Startseite
                header("refresh:1;url=index.php");
            } else {
                // Umleitung zur Registrierungsseite
                header("Location: registrierung.php");
                exit;
            }
        } else {
            $_SESSION['error'] = 'Bitte gültige E-Mail und Passwort eingeben!';

            // Umleitung zur Registrierungsseite
            header("Location: registrierung.php");
            exit;
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
            $_SESSION['error'] = 'Dieser Benutzer existiert nicht!';

            // Umleitung zur Loginseite
            header("Location: anmeldung.php");
            exit;
        }
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