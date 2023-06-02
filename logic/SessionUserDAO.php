<?php
include_once "User.php";
include_once "UserDAO.php";
include_once "SessionCardDAO.php";

class SessionUserDAO implements UserDAO
{

    public function createUser($email, $password)
    {
        $user = new User($email, $password);

        $_SESSION['users'][$email] = serialize($user);
        $_SESSION['loggedInUser'] = serialize($user);
    }

    public function login($user)
    {
        $_SESSION['loggedInUser'] = serialize($user);
    }

    public function logout()
    {
        unset($_SESSION['loggedInUser']);
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
        if (isset($_SESSION['cards'])) {
            foreach ($_SESSION['cards'] as $card) {
                if (unserialize($card)->owner == $user) {
                    $cards[] = $card;
                }
            }
        }
        return $cards;
    }

    public function get($email)
    {
        if (isset($_SESSION['users'][$email])) {
            return unserialize($_SESSION['users'][$email]);
        }
        return null;
    }
}
?>