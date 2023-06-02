<?php
include_once "User.php";
include_once "UserDAO.php";
include_once "SessionCardDAO.php";

if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

class SessionUserDAO implements UserDAO
{

    public function createUser($email, $password, $repassword)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($password) && !empty($repassword)) {
            if ($password !== $repassword) {
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
    }

    public function login($email, $password)
    {
        if (isset($_SESSION['users'][$email])) {
            $user = unserialize($_SESSION['users'][$email]);
    
            if (password_verify($password, $user->password)) {
                $_SESSION['loggedInUser'] = serialize($user);
    
                // Umleitung zur Startseite
                header("Location: index.php");
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

    public function logout()
    {
        unset($_SESSION['loggedInUser']);

        // Umleitung zur Startseite
        header("Location: index.php");
        exit;
    }

    public function loadClaimedCards(): array 
    {
        $user = $_SESSION['loggedInUser'];
        $claimedCards = array();
        if (isset($_SESSION['claimedCards'][$user])) {
            foreach ($_SESSION['claimedCards'][$user] as $card) {
                $claimedCards[] = $card;
            }
        }
        return $claimedCards;
    }

    public function loadCards(): array 
    {
        $user = unserialize($_SESSION['loggedInUser']);
        $cards = array();
        if(isset($_SESSION['cards'])) {
            foreach($_SESSION['cards'] as $card) {
                if (unserialize($card)->owner == $user) {
                    $cards[] = $card;
                }
            }
        }
        return $cards;
    }
}
?>