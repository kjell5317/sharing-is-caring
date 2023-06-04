<?php
include_once "User.php";
include_once "Card.php";
include_once "CardDAO.php";

class SQLCardDAO implements CardDAO
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
            addr_id INT NOT NULL,
            claimer_email VARCHAR(100),
            creator_email VARCHAR(100) NOT NULL,
            FOREIGN KEY (claimer_email) REFERENCES sharing_user(email),
            FOREIGN KEY (creator_email) REFERENCES sharing_user(email),
            FOREIGN KEY (addr_id) REFERENCES sharing_address(id)
        )
        ");

        //Wenn sie vorher nicht existiert hat, dann Testkarte einfügen
        if(!$result->fetch()) {
            $stmt1 = $this->db->prepare("INSERT INTO sharing_address (postcode, city, street, house_number) VALUES (?, ?, ?, ?)");
            $stmt1->execute(["26203", "Ehrenburg", "Hauptstraße", "12"]);
            $addr_id = $this->db->lastInsertId();
            $stmt2 = $this->db->prepare("
            INSERT INTO sharing_post (title, mhd, img_path, description, food_type, addr_id, claimer_email, creator_email)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt2->execute(["Halber Döner", "04.06.2023", "assets/lecker.jpg", "Hier könnte deine Werbung stehen", "vegan",
                    $addr_id, null, "test@test.de"]);
        }
    }

    public function saveCard($card)
    {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare("
            INSERT INTO sharing_post (title, mhd, img_path, description, food_type, addr_id, claimer_email, creator_email)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $stmt->execute([$card->title, $card->expirationDate, $card->imagePath, $card->description, 
                    $card->foodType, $card->addr_id, $card->claimer, $card->owner]);
            $this->db->commit();
            return $this->db->lastInsertId();
        }  catch (PDOException $e) {
            $this->db->rollback();
            error_log("Fehler bei Eintrag speichern... -> " . $e);
            $_SESSION['error'] = "Es ist ein Fehler aufgetreten! Versuche es später erneut.";
            return null;
        }
    }

    public function updateCard($card)
    {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare("
            UPDATE sharing_post SET title = ?, mhd = ?, img_path = ?, description = ?, food_type = ?, addr_id = ?, claimer_email = ?, creator_email = ?
            WHERE post_id = ?
            ");
            
            $stmt->execute([$card->title, $card->expirationDate, $card->imagePath, $card->description, 
                    $card->foodType, $card->addr_id, $card->claimer, $card->owner]);
            $this->db->commit();
            return true;
        }  catch (PDOException $e) {
            $this->db->rollback();
            error_log("Fehler bei Eintrag update... -> " . $e);
            $_SESSION['error'] = "Es ist ein Fehler aufgetreten! Versuche es später erneut.";
            return false;
        }
    }

    public function loadCard($id)
    {
        $sql = "SELECT * FROM sharing_post WHERE post_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            return new Card($row['post_id'], $row['title'], $row['food_type'], $row['mhd'], $row['addr_id'], $row['img_path'], $row['description'], $row['creator_email'], $row['claimer_email']);
        }
        return null;
    }

    public function claimCard()
    {
        $card = $this->loadCard($_GET['id']);
        $user = $_SESSION['loggedInUser'];
        if (isset($user)) {
            if ($card->claimer == null) {
                $this->db->beginTransaction();
                try {
                    $stmt = $this->db->prepare("
                    UPDATE sharing_post SET claimer_email = ? WHERE post_id = ?
                    ");
                    
                    $stmt->execute([unserialize($user)->email, $card->id]);
                    $this->db->commit();
                    return true;
                }  catch (PDOException $e) {
                    $this->db->rollback();
                    error_log("Fehler bei Claimer update... -> " . $e);
                    $_SESSION['error'] = "Es ist ein Fehler aufgetreten! Versuche es später erneut.";
                    return false;
                }
            }
        }
    }

    public function unclaimCard()
    {
        $card = $this->loadCard($_GET['id']);
        $user = $_SESSION['loggedInUser'];
        if (isset($user)) {
            if ($card->claimer == unserialize($user)->email) {
                $this->db->beginTransaction();
                try {
                    $stmt = $this->db->prepare("
                    UPDATE sharing_post SET claimer_email = ? WHERE post_id = ?
                    ");
                    
                    $stmt->execute([null, $card->id]);
                    $this->db->commit();
                    return true;
                }  catch (PDOException $e) {
                    $this->db->rollback();
                    error_log("Fehler bei Claimer update... -> " . $e);
                    $_SESSION['error'] = "Es ist ein Fehler aufgetreten! Versuche es später erneut.";
                    return false;
                }
            }
        }
    }

    public function loadUserClaimedCards(): array
    {
        if(isset($_SESSION['loggedInUser'])) {
            $user = $_SESSION['loggedInUser'];
            $claimedCards = array();
            $sql = "SELECT * FROM sharing_post WHERE claimer_email = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([unserialize($user)->email]);
    
            $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($cards as $row) {
                $claimedCards[] = serialize(new Card($row['post_id'], $row['title'], $row['food_type'], $row['mhd'], $row['addr_id'],
                 $row['img_path'], $row['description'], $row['creator_email'], $row['claimer_email']));
            }
            return $claimedCards;
        }
        return null;
    }

    public function loadUserCards(): array
    {
        if(isset($_SESSION['loggedInUser'])) {
            $user = $_SESSION['loggedInUser'];
            $ownedCards = array();
            $sql = "SELECT * FROM sharing_post WHERE creator_email = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([unserialize($user)->email]);
    
            $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($cards as $row) {
                $ownedCards[] = serialize(new Card($row['post_id'], $row['title'], $row['food_type'], $row['mhd'], $row['addr_id'], 
                $row['img_path'], $row['description'], $row['creator_email'], $row['claimer_email']));
            }
            return $ownedCards;
        }
        return null;
    }

    public function loadAllCards(): array
    {
        $allCards = array();
        $sql = "SELECT * FROM sharing_post";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($cards as $row) {
            $allCards[] = serialize(new Card($row['post_id'], $row['title'], $row['food_type'], $row['mhd'], $row['addr_id'], 
            $row['img_path'], $row['description'], $row['creator_email'], $row['claimer_email']));
        }
        return $allCards;
    }

    public function loadAllUnclaimedCards(): array
    {
        $unclaimedCards = array();
        $sql = "SELECT * FROM sharing_post WHERE claimer_email IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($cards as $row) {
            $unclaimedCards[] = serialize(new Card($row['post_id'], $row['title'], $row['food_type'], $row['mhd'], $row['addr_id'], 
            $row['img_path'], $row['description'], $row['creator_email'], $row['claimer_email']));
        }
        return $unclaimedCards;
    }
}
?>