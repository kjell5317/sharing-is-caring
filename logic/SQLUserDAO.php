<?php
include_once "User.php";
include_once "UserDAO.php";

class SQLUserDAO implements UserDAO
{
    protected $db;

    public function __construct()
    {
        if($this->db==null) {
            try {
                $this->db = new PDO("sqlite:" . "database/database.db","","",array(
                    PDO::ATTR_PERSISTENT => true
                ));
                $this->initializeDatabase();
            } catch(PDOExeption $e) {
                
            }
        }
    }

    private function initializeDatabase()
    {
        //Prüfen ob Tabelle Existiert
        $result = $this->db->query("PRAGMA table_info(sharing_user)");

        // Tabelle erstellen, wenn sie nicht existiert
        $this->db->exec("
        CREATE TABLE IF NOT EXISTS sharing_user (
            email VARCHAR(100) PRIMARY KEY,
            password VARCHAR(255) NOT NULL
        )
        ");

        //Wenn sie vorher nicht existiert hat, dann Testuser einfügen
        if(!$result->fetch()) {
            $stmt = $this->db->prepare("INSERT INTO sharing_user (email, password) VALUES (?, ?)");
            $stmt->execute(["test@test.de", password_hash("123", PASSWORD_DEFAULT)]);
        }
    }

    public function createUser($email, $password) : bool
    {
        $this->db->beginTransaction();
        try {
            // Überprüfen, ob der Benutzer bereits existiert
            $stmt = $this->db->prepare("SELECT * FROM sharing_user WHERE email = ?");
            $stmt->execute([$email]);
            $exists = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Wenn der Benutzer nicht existiert, fügen Sie ihn ein
            if (!$exists) {
                $stmt = $this->db->prepare("INSERT INTO sharing_user (email, password) VALUES (?, ?)");
                $stmt->execute([$email, $password]);
    
                // Commit
                $this->db->commit();
                $user = new User($email, $password);
                $_SESSION['loggedInUser'] = serialize($user);
                return true;
            } else {
                // Benutzer existiert bereits
                $_SESSION['error'] = "Du hast bereits ein Konto!";
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
        $sql = "SELECT * FROM sharing_user WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            return new User($row['email'], $row['password']);
        }
        return null;
    }
}
?>