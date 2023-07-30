<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/sharing-is-caring/logic/user/User.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/sharing-is-caring/logic/user/UserDAO.php";
include_once "Database.php";

class SQLUserDAO implements UserDAO
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function createUser(string $email, string $password, int $consent): bool
    {
        $this->db->beginTransaction();
        try {
            // Überprüfen, ob der Benutzer bereits existiert
            $stmt = $this->db->prepare("SELECT * FROM sharing_user WHERE email = ?");
            if (!$stmt->execute([$email]))
                throw new PDOException;
            $exists = $stmt->fetch(PDO::FETCH_ASSOC);

            // Wenn der Benutzer nicht existiert, fügen Sie ihn ein
            if (!$exists) {
                $stmt = $this->db->prepare("INSERT INTO sharing_user (email, password, validated, consent) VALUES (?, ?, ?, ?)");
                $stmt->execute([$email, $password, 0, $consent]);

                // Commit
                $this->db->commit();
                $usr_id = $this->db->lastInsertId();
                $user = new User($usr_id, $email, $password, 0, $consent);
                $_SESSION['user'] = serialize($user);
                return true;
            } else {
                $user = new User($exists['usr_id'], $email, $password, 1, $consent);
                $_SESSION['user'] = serialize($user);
                // Benutzer existiert bereits
                return false;
            }
        } catch (PDOException $e) {
            //Transaktion rückgängig machen
            $this->db->rollback();
            error_log("Fehler bei Benutzer speichern... -> " . $e);
            $_SESSION['error'] = "Es ist ein Fehler aufgetreten! Versuche es später erneut.";
            return false;
        }
    }

    public function login($user): bool
    {   
        if (isset($_SESSION['securityToken'])) {
            unset($_SESSION['securityToken']);
        }
        $_SESSION['loggedInUser'] = serialize($user);
        return true;
    }

    public function logout(): bool
    {   
        unset($_SESSION['securityToken']);
        unset($_SESSION['loggedInUser']);
        return true;
    }

    public function get(string $email): ?User
    {
        $sql = "SELECT * FROM sharing_user WHERE email = ? AND validated = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new User($row['usr_id'], $row['email'], $row['password'], $row['validated'], $row['consent']);
        }
        return null;
    }

    public function validate($usr_id): bool
    {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare("
            UPDATE sharing_user SET validated = ? WHERE usr_id = ?
            ");

            if (!$stmt->execute([1, $usr_id]))
                throw new PDOException;
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollback();
            error_log("Fehler bei validation update... -> " . $e);
            $_SESSION['error'] = "Es ist ein Fehler aufgetreten! Versuche es später erneut.";
            return false;
        }
    }

    public function setConsent(int $usr_id, int $consent)
    {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare("
            UPDATE sharing_user SET consent = ? WHERE usr_id = ?
            ");

            if (!$stmt->execute([$consent, $usr_id]))
                throw new PDOException;
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollback();
            error_log("Fehler bei consent update... -> " . $e);
            $_SESSION['error'] = "Es ist ein Fehler aufgetreten! Versuche es später erneut.";
            return false;
        }
    }
}
?>