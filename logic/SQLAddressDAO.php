<?php
include_once "Address.php";
include_once "AddressDAO.php";

class SQLAddressDAO implements AddressDAO
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
    }

    public function save($address)
    {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare("
            INSERT INTO sharing_address (postcode, city, street, house_number)
            VALUES (?, ?, ?, ?)
            ");
            
            $stmt->execute([$address->postalCode, $address->city, $address->street, $address->number]);
            $this->db->commit();
            return $this->db->lastInsertId();
        }  catch (PDOException $e) {
            $this->db->rollback();
            error_log("Fehler bei Adresse speichern... -> " . $e);
            $_SESSION['error'] = "Es ist ein Fehler aufgetreten! Versuche es später erneut.";
            return null;
        }
    }

    public function get($id)
    {
        $sql = "SELECT * FROM sharing_address WHERE adr_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            return new Address($row['adr_id'], $row['postcode'], $row['city'], $row['street'], $row['house_number']);
        }
        return null;
    }
}
?>