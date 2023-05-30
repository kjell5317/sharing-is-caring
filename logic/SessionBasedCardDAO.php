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
            if ($card->getOwner == $user) {
                $back[] = unserialize($card);
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
}
?>