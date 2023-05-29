<?php
session_start();

class User {
    public $email;
    public $password;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /*
    * Anfrage ist eine Registrierung
    */
    if (isset($_POST['register'])) {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $repassword = $_POST['repassword'] ?? '';

        if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($password) && !empty($repassword)) {
            if($password !== $repassword) {
                $_SESSION['error'] = 'Die Passwörter stimmen nicht überein!';

                // Umleitung zur Registrierungsseite
                header("Location: registrierung.php");
                exit;
            }
            $user = new User;
            $user->email = $email;
            $user->password = password_hash($password, PASSWORD_DEFAULT);

            $_SESSION['users'][$email] = serialize($user);
            $_SESSION['loggedInUser'] = serialize($user);

            // Umleitung zur Startseite
            header("Location: ./index.php");
            exit;
        } else {
            $_SESSION['error'] = 'Bitte gültige E-Mail und Passwort eingeben';

            // Umleitung zur Registrierungsseite
            header("Location: registrierung.php");
            exit;
        }
    /*
    * Anfrage ist ein Login
    */
    } else if (isset($_POST['login'])) {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (isset($_SESSION['users'][$email])) {
            $user = unserialize($_SESSION['users'][$email]);
            
            if (password_verify($password, $user->password)) {
                $_SESSION['loggedInUser'] = serialize($user);

                // Umleitung zur Startseite
                header("Location: ./index.php");
                exit;
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
    unset($_SESSION['loggedInUser']);

    // Umleitung zur Startseite
    header("Location: ./index.php");
    exit;
}

$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);

?>