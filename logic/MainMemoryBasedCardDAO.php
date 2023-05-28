<?php
include_once "CardDAO.php";
include_once "Card.php";
class MainMemoryBasedCardDAO implements CardDAO {

    private static $cards;
    private static $instance;

    public static function getInstance(): MainMemoryBasedCardDAO
    {
        if (self::$instance === null) {
            self::$instance = new self();
            self::$cards = array();
        }

        return self::$instance;
    }

    private function __construct() {}
    public function saveCard(Card $card):bool {
        self::$cards[] = $card;
        return true;
    }

    public function loadCard(): Card {
        if (isset(self::$cards) && count(self::$cards) > 0) {
            $randomIndex = rand(0, count(self::$cards) - 1);
            return self::$cards[$randomIndex];
        } else {
            return Card::getEmptyCard();
        }
    }
    

    public function loadCardsOfUser(User $user):array {
        return array();
    }
}
?>