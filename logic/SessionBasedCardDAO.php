<?php
include "usermanagement.php";
include_once "CardDAO.php";
include_once "Card.php";

class SessionBasedCardDAO implements CardDAO  {

    private static $instance;
    public static function getInstance(): SessionBasedCardDAO
    {
        if (self::$instance === null) {
            self::$instance = new self();
            if (!isset($_SESSION['cards'])) {
                $_SESSION['cards'] = array();
            }
            if(!isset($_SESSION['claimedCards'])) {
                $_SESSION['claimedCards'] = array();
            }
        }

        return self::$instance;
    }

    private function __construct() {}

    public function saveCard(Card $card):bool  {
        if (isset($_SESSION['cards'])) {
            $_SESSION['cards'][] = serialize($card); 
            return true;
        } else  {
            return false;
        }
    }

    public function loadCard():Card {
        return unserialize($_SESSION['cards'][0]);
    }

    public function loadCardsOfUser(User $user): array {
        $back = array();
        foreach($_SESSION['cards'] as $card) {
            $card = unserialize($card);
            if ($card->getOwner() == $user) {
                $back[] = $card;
            }
        }
        return $back;
    }

    public function loadAllCards(): array  {
        $back = array();
        foreach($_SESSION['cards'] as $card) {
            $back[] = unserialize($card);
        }
        return $back;
    }

    public function loadAllUnclaimedCards():  array{
        $back = array() ;
        foreach($_SESSION['cards'] as $card) {
            $card = unserialize($card);
            if (!$card->isClaimed()) {
                $back[] =$card;
            }
        }
        return $back;
    }

    public function storeClaimedCard() {
        if (isset($_SESSION['lastDisplayedCard'])) {
            $loggedInUser = $_SESSION['loggedInUser'];
            $cardToStore = $_SESSION['lastDisplayedCard'];
    
            $userClaimedCards = isset($_SESSION['claimedCards'][$loggedInUser]) ? $_SESSION['claimedCards'][$loggedInUser] : [];
    
            // Check if the card is already claimed
            $isCardAlreadyClaimed = false;
            foreach ($userClaimedCards as $claimedCard) {
                if ($claimedCard === $cardToStore) {
                    $isCardAlreadyClaimed = true;
                    break;
                }
            }
    
            // Store the card only if it is not already claimed
            if (!$isCardAlreadyClaimed) {
                $_SESSION['claimedCards'][$loggedInUser][] = $cardToStore;
            }
        }
    }
    
    
    public function loadRandomCard():Card {
        if (count($_SESSION['cards'])  > 1) { 
            $rand = rand(0, count($_SESSION['cards']) - 1);
        } else if (count($_SESSION['cards']) === 0) {
            echo "Failed to load your Card";
            return Card::getEmptyCard();
        } else  {
            $rand = 0;
        }
        return unserialize($_SESSION['cards'][$rand]);
    }

    public function loadClaimedCardsOfUser(User $user): array {
        $user = serialize($user);
        $claimedCards = [];
        if (isset($_SESSION['claimedCards'][$user])) {
            foreach ($_SESSION['claimedCards'][$user] as $card) {
                $claimedCards[] = unserialize($card);
            }
        }
        return $claimedCards;
    }
    
}
?>