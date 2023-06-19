<?php
include_once "User.php";
include_once "Card.php";
include_once "CardDAO.php";

class SQLCardDAO implements CardDAO
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function saveCard($card)
    {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare("
            INSERT INTO sharing_post (title, mhd, img_path, description, food_type, adr_id, claimer_id, creator_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                $card->title, $card->expirationDate, $card->imagePath, $card->description,
                $card->foodType, $card->adr_id, $card->claimer, $card->owner
            ]);
            $this->db->commit();
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
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
            UPDATE sharing_post SET title = ?, mhd = ?, img_path = ?, description = ?, food_type = ?, adr_id = ?, claimer_id = ?, creator_id = ?
            WHERE post_id = ?
            ");

            $stmt->execute([
                $card->title, $card->expirationDate, $card->imagePath, $card->description,
                $card->foodType, $card->adr_id, $card->claimer, $card->owner
            ]);
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
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

        if ($row) {
            return new Card($row['post_id'], $row['title'], $row['food_type'], $row['mhd'], $row['adr_id'], $row['img_path'], $row['description'], $row['creator_id'], $row['claimer_id']);
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
                    UPDATE sharing_post SET claimer_id = ? WHERE post_id = ?
                    ");

                    $stmt->execute([unserialize($user)->id, $card->id]);
                    $this->db->commit();
                    return true;
                } catch (PDOException $e) {
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
            if ($card->claimer == unserialize($user)->id) {
                $this->db->beginTransaction();
                try {
                    $stmt = $this->db->prepare("
                    UPDATE sharing_post SET claimer_id = ? WHERE post_id = ?
                    ");

                    $stmt->execute([null, $card->id]);
                    $this->db->commit();
                    return true;
                } catch (PDOException $e) {
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
        if (isset($_SESSION['loggedInUser'])) {
            $user = $_SESSION['loggedInUser'];
            $claimedCards = array();
            $sql = "SELECT * FROM sharing_post WHERE claimer_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([unserialize($user)->id]);

            $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($cards as $row) {
                $claimedCards[] = serialize(
                    new Card(
                        $row['post_id'], $row['title'], $row['food_type'], $row['mhd'], $row['adr_id'],
                        $row['img_path'], $row['description'], $row['creator_id'], $row['claimer_id']
                    )
                );
            }
            return $claimedCards;
        }
        return null;
    }

    public function loadUserCards(): array
    {
        if (isset($_SESSION['loggedInUser'])) {
            $user = $_SESSION['loggedInUser'];
            $ownedCards = array();
            $sql = "SELECT * FROM sharing_post WHERE creator_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([unserialize($user)->id]);

            $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($cards as $row) {
                $ownedCards[] = serialize(
                    new Card(
                        $row['post_id'], $row['title'], $row['food_type'], $row['mhd'], $row['adr_id'],
                        $row['img_path'], $row['description'], $row['creator_id'], $row['claimer_id']
                    )
                );
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
            $allCards[] = serialize(
                new Card(
                    $row['post_id'], $row['title'], $row['food_type'], $row['mhd'], $row['adr_id'],
                    $row['img_path'], $row['description'], $row['creator_id'], $row['claimer_id']
                )
            );
        }
        return $allCards;
    }

    public function loadAllUnclaimedCards(): array
    {
        $unclaimedCards = array();
        $sql = "SELECT * FROM sharing_post WHERE claimer_id IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($cards as $row) {
            $unclaimedCards[] = serialize(
                new Card(
                    $row['post_id'], $row['title'], $row['food_type'], $row['mhd'], $row['adr_id'],
                    $row['img_path'], $row['description'], $row['creator_id'], $row['claimer_id']
                )
            );
        }
        return $unclaimedCards;
    }

    public function queryCards($q): array
    {
        $queryedCards = array();
        $sql = "SELECT * FROM sharing_post WHERE LOWER(title) LIKE ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($cards as $row) {
            $queryedCards[] = serialize(
                new Card(
                    $row['post_id'], $row['title'], $row['food_type'], $row['mhd'], $row['adr_id'],
                    $row['img_path'], $row['description'], $row['creator_id'], $row['claimer_id']
                )
            );
        }
        return $queryedCards;
    }
}
?>