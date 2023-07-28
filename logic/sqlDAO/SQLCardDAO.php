<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/sharing-is-caring/logic/user/User.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/sharing-is-caring/logic/card/Card.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/sharing-is-caring/logic/card/CardDAO.php";
include_once "Database.php";

class SQLCardDAO implements CardDAO
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function saveCard(Card $card)
    {
        $this->db->beginTransaction();
        $date = date_format(date_create($card->expirationDate), "d.m.y");
        try {
            $stmt = $this->db->prepare("
            INSERT INTO sharing_post (title, mhd, img_path, description, food_type, adr_id, claimer_id, creator_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                $card->title,
                $date, $card->imagePath, $card->description,
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

    public function updateCard(Card $card)
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

    public function loadCard(string $id)
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
        $claimedCards = array();
        if (isset($_SESSION['loggedInUser'])) {
            $user = $_SESSION['loggedInUser'];
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
        }
        return $claimedCards;
    }

    public function loadUserCards(): array
    {
        $ownedCards = array();
        if (isset($_SESSION['loggedInUser'])) {
            $user = $_SESSION['loggedInUser'];

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
        }
        return $ownedCards;
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

    public function queryUnclaimedCards(?string $q): array
    {
        $queryedCards = array();
        $sql = "SELECT * FROM sharing_post WHERE LOWER(title) LIKE ? AND claimer_id IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(["%" . $q . "%"]);

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

    public function queryUnclaimedCardsSequential(int $number, ?string $q): array
    {
        if (!(isset($_SESSION['currentNumberOfCards']))) { // Der landet hier immer wieder auf null
            $_SESSION['currentNumberOfCards'] = 0;
        }
        $sql = "SELECT * FROM sharing_post WHERE LOWER(title) LIKE ? AND claimer_id IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(["%" . $q . "%"]);
        $CardIds = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $maxNumber = count($CardIds);

        $cards = [];
        $goal = $_SESSION['currentNumberOfCards'] + $number;
        while (($_SESSION['currentNumberOfCards'] < $maxNumber) && $_SESSION['currentNumberOfCards'] < $goal) {
            $cards[] = serialize($this->loadCard($CardIds[$_SESSION['currentNumberOfCards']]['post_id']));
            $_SESSION['currentNumberOfCards'] += 1;
        }
        return $cards;
    }

    public function loadUnclaimedCardsSequential(int $number): array
    {
        if (!(isset($_SESSION['currentNumberOfCards']))) { // Der landet hier immer wieder auf null
            $_SESSION['currentNumberOfCards'] = 0;
        }
        $sql = "SELECT post_id FROM sharing_post WHERE claimer_id IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $CardIds = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $maxNumber = count($CardIds);

        $cards = [];
        $goal = $_SESSION['currentNumberOfCards'] + $number;
        while (($_SESSION['currentNumberOfCards'] < $maxNumber) && $_SESSION['currentNumberOfCards'] < $goal) {
            $cards[] = serialize($this->loadCard($CardIds[$_SESSION['currentNumberOfCards']]['post_id']));
            $_SESSION['currentNumberOfCards'] += 1;
        }
        return $cards;
    }
}
?>