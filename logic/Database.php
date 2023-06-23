<?php
class Database
{
    private static $instance = null;
    private $db;

    public function __construct()
    {   
        if($this->db==null) {
            try {
                $this->db = new PDO("sqlite:" . "database/database.db","","",array(
                    PDO::ATTR_PERSISTENT => true
                ));
                $this->initializeDatabase();
            } catch(PDOException $e) {
                
            }
        }
    }

    public static function getInstance()
    {
        if(!self::$instance)
        {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    private function initializeDatabase()
    {
        //Prüfen ob Tabelle Existiert
        $result = $this->db->query("PRAGMA table_info(sharing_post)");

        // Tabelle erstellen, wenn sie nicht existiert
        $this->db->exec("
        CREATE TABLE IF NOT EXISTS sharing_address (
            adr_id INTEGER PRIMARY KEY,
            postcode VARCHAR(10) NOT NULL,
            city VARCHAR(100) NOT NULL,
            street VARCHAR(100) NOT NULL,
            house_number VARCHAR(10) NOT NULL
        )
        ");

        // Tabelle erstellen, wenn sie nicht existiert
        $this->db->exec("
        CREATE TABLE IF NOT EXISTS sharing_post (
            post_id INTEGER PRIMARY KEY,
            title VARCHAR(100) NOT NULL,
            mhd DATE NOT NULL,
            img_path VARCHAR(255),
            description VARCHAR(65535),
            food_type VARCHAR(20) NOT NULL,
            adr_id INT NOT NULL,
            claimer_id VARCHAR(100),
            creator_id VARCHAR(100) NOT NULL,
            FOREIGN KEY (claimer_id) REFERENCES sharing_user(usr_id),
            FOREIGN KEY (creator_id) REFERENCES sharing_user(usr_id),
            FOREIGN KEY (adr_id) REFERENCES sharing_address(adr_id)
        )
        ");

        // Tabelle erstellen, wenn sie nicht existiert
        $this->db->exec("
        CREATE TABLE IF NOT EXISTS sharing_user (
            usr_id INTEGER PRIMARY KEY,
            email VARCHAR(100) NOT NULL,
            password VARCHAR(255) NOT NULL
        )
        ");

        //Wenn sie vorher nicht existiert hat, dann Testkarte und Testuser einfügen
        if(!$result->fetch()) {
            $stmt = $this->db->prepare("INSERT INTO sharing_user (email, password) VALUES (?, ?)");
            $stmt->execute(["test@test.de", password_hash("123", PASSWORD_DEFAULT)]);
            $usr_id = $this->db->lastInsertId();

            $stmt1 = $this->db->prepare("INSERT INTO sharing_address (postcode, city, street, house_number) VALUES (?, ?, ?, ?)");
            $stmt1->execute(["26203", "Ehrenburg", "Hauptstraße", "12"]);
            $adr_id = $this->db->lastInsertId();
            $stmt2 = $this->db->prepare("
            INSERT INTO sharing_post (title, mhd, img_path, description, food_type, adr_id, claimer_id, creator_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt2->execute(["Halber Döner", "04.06.2023", "assets/lecker.jpg", "Hier könnte deine Werbung stehen", "vegan",
                    $adr_id, null, $usr_id]);
        }
    }
    public function getDatabase()
    {
        try {
            $this->db->query('SELECT 1');
            return $this->db;
        } catch (PDOException $e) {
            echo "Die Verbindung ist nicht mehr offen: " . $e->getMessage();
        }
    }
}
?>