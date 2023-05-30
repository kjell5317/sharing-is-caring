<?php
include "usermanagement.php";
include "CardDAO.php";

class SessionBasedCardDAO implements CardDAO  {

    private static $instance;
    public static function getInstance(): SessionBasedCardDAO
    {
        if (self::$instance === null) {
            self::$instance = new self();
            $_SESSION['cards'] = array();
        }

        return self::$instance;
    }

    private function __construct() {}

    public function saveCard(Card $card):bool  {
        if (isset($_SESSION['cards'])) {
            $_SESSION['cards'][] = $card; 
            return true;
        } else  {
            return false;
        }
    }

    public function loadCard():Card {
        echo json_encode($_SESSION['cards']);
        return $_SESSION['cards'][0];
    }

    public function loadCardsOfUser(User $user): array {
        $back = array();
        foreach($_SESSION['cards'] as $card) {
            if ($card->getOwner == $user) {
                $back[] = $card;
            }
        }
        return $back;
    }

    public function loadAllCards(): array  {
        return $_SESSION['cards'];
    }
}
?>