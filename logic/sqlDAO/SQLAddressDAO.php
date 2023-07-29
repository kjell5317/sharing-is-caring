<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/sharing-is-caring/logic/address/Address.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/sharing-is-caring/logic/address/AddressDAO.php";

class SQLAddressDAO implements AddressDAO
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function save($address)
    {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare("
            INSERT INTO sharing_address (postcode, city, street, house_number)
            VALUES (?, ?, ?, ?)
            ");

            if (!$stmt->execute([$address->postalCode, $address->city, $address->street, $address->number]))
                throw new PDOException;
            $this->db->commit();
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
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
        if ($row) {
            return new Address($row['adr_id'], $row['postcode'], $row['city'], $row['street'], $row['house_number']);
        }
        return null;
    }
}
?>