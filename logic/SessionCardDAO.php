<?php
include_once "User.php";
include_once "Card.php";
include_once "CardDAO.php";

if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start(); 
}

class SessionCardDAO implements CardDAO 
{

    public function saveCard($title, $foodType, $expirationDate, $place, $postalCode, $image, $description, $claimed, $owner)
    {
        $pathToImages = "tmp/images/";
        $imagePath = $pathToImages . basename($image['name']);
        while(file_exists($imagePath)) {
            $imagePath = $pathToImages . strval(rand(2000000)) . basename(($image['name'])); // give kinda random name to image if an image with existing name is uploaded;
        }
        move_uploaded_file($image['tmp_name'],"../" . $imagePath);

        $card = new Card;
        $card->id = random_int(10000,99999);
        $card->title = $title;
        $card->foodType = $foodType;
        $card->expirationDate = $expirationDate;
        $card->place = $place;
        $card->postalCode = $postalCode;
        $card->imagePath = $imagePath;
        $card->description = $description;
        $card->claimed = $claimed;
        $card->owner = unserialize($_SESSION['loggedInUser']);

        $_SESSION['cards'][$card->id] = serialize($card); 

        // Create a new instance of the Card class
        header("Location: ../meine-eintraege.php");
        exit;
    }

    public function updateCard($id, $card)
    {
        $_SESSION['cards'][$id] = serialize($card); 
    }

    public function claimCard() 
    {
        $cardmanager = new SessionCardDAO();
        $card = $cardmanager->loadCard($_GET['id']);
        if(isset($_SESSION['loggedInUser'])) {
            if(!$card->claimed) {
                $_SESSION['claimedCards'][$_SESSION['loggedInUser']][$_GET['id']] = serialize($card);
                $card->claimed = true;
                $cardmanager->updateCard($_GET['id'], $card);
            }
        }
    }

    public function unclaimCard() 
    {
        $cardmanager = new SessionCardDAO();
        $card = $cardmanager->loadCard($_GET['id']);
        if(isset($_SESSION['loggedInUser'])) {
            if($card->claimed) {
                unset($_SESSION['claimedCards'][$_SESSION['loggedInUser']][$_GET['id']]);
                $card->claimed = false;
                $cardmanager->updateCard($_GET['id'], $card);
            }
        }
    }

    public function loadCard($id): Card 
    {
        if(isset($_SESSION['cards'])) {
            foreach($_SESSION['cards'] as $card) {
                if (unserialize($card)->id == $id) {
                    return unserialize($card);
                }
            }
        }
        return new Card;
    }

    public function loadAllCards(): array
    {
        $cards = array();
        if(isset($_SESSION['cards'])) {
            foreach($_SESSION['cards'] as $card) {
                $cards[] = $card;
            }
        }
        return $cards;
    }

    public function loadAllUnclaimedCards(): array 
    {
        $cards = array();
        if(isset($_SESSION['cards'])) {
            foreach($_SESSION['cards'] as $card) {
                if (!unserialize($card)->claimed) {
                    $cards[] =$card;
                }
            }
        }
        return $cards;
    }
}
?>