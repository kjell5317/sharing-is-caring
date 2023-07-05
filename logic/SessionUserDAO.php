<?php
include_once "User.php";
include_once "UserDAO.php";
include_once "SessionCardDAO.php";

class SessionUserDAO implements UserDAO
{

    public function createUser($email, $password) : bool
    {
        $user = new User(uniqueid(), $email, $password, 0);

        if (isset($_SESSION["users"][$email])) {
            $_SESSION["error"] = "Du hast bereits ein Konto!";
            return false;
        }

        $_SESSION['users'][$email] = serialize($user);
        $_SESSION['loggedInUser'] = serialize($user);

        return true;
    }

    public function login($user) : bool
    {
        $_SESSION['loggedInUser'] = serialize($user);

        return true;
    }

    public function logout() : bool
    {
        unset($_SESSION['loggedInUser']);
        
        return true;
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