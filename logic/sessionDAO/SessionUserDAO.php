<?php
include_once "logic/user/User.php";
include_once "logic/user/UserDAO.php";
include_once "locic/sessionDAO/SessionCardDAO.php";

class SessionUserDAO implements UserDAO
{

    public function createUser($email, $password, $consent): bool
    {
        $user = new User(uniqid(), $email, $password, 0, $consent);

        if (isset($_SESSION["users"][$email])) {
            $_SESSION["error"] = "Du hast bereits ein Konto!";
            return false;
        }

        $_SESSION['users'][$email] = serialize($user);
        $_SESSION['loggedInUser'] = serialize($user);

        return true;
    }

    public function login($user): bool
    {
        $_SESSION['loggedInUser'] = serialize($user);

        return true;
    }

    public function logout(): bool
    {
        unset($_SESSION['loggedInUser']);

        return true;
    }

    public function get(string $email): ?User
    {
        if (isset($_SESSION['users'][$email])) {
            return unserialize($_SESSION['users'][$email]);
        }
        return null;
    }
}
?>