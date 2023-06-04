<?php
include_once "SessionUserDAO.php";

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$userDAO = new SessionUserDAO();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /*
     * Anfrage ist eine Registrierung
     */
    if (isset($_POST['register'])) {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $repassword = $_POST['repassword'] ?? '';

        if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($password) && !empty($repassword)) {
            if ($password !== $repassword) {
                $_SESSION['error'] = 'Die Passwörter stimmen nicht überein!';

                // Umleitung zur Registrierungsseite
                header("Location: registrierung.php");
                exit;
            }
            if (isset($_SESSION["users"][$email])) {
                $_SESSION["error"] = "Du hast bereits ein Konto!";

                header("Location: anmeldung.php");
                exit;
            }

            $password = password_hash($password, PASSWORD_DEFAULT);
            $userDAO->createUser($email, $password);
            $_SESSION['info'] = 'Du wurdest erfolgreich registriert! Viel Spaß beim teilen.';

            // Umleitung zur Startseite
            header("refresh:2;url=index.php"); 
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

        $user = $userDAO->get($email);
        if (isset($user)) {
            if (password_verify($password, $user->password)) {
                $userDAO->login($user);
                $_SESSION['info'] = 'Du wurdest erfolgreich eingeloggt! Viel Spaß beim teilen.';

                // Umleitung zur Startseite
                header("refresh:2;url=index.php"); 
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
    $userDAO->logout();
    $_SESSION['info'] = 'Du wurdest erfolgreich ausgeloggt! Bis zum nächsten mal.';

    // Umleitung zur Startseite
    header("Location: index.php");
    exit;
}

$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);

$info = $_SESSION['info'] ?? '';
unset($_SESSION['info']);

?>