<?php
include_once "./CardDAO.php";
class DBBasedCardDAO implements CardDAO {

    private $instance; 

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function saveCard(Card $card):bool {
        return true;
    }

    public function loadCard():Card {
        return Card::getEmptyCard();
    }

    public function loadCardsOfUser(User $user) {
       return array();
    }

    public function loadAllCards() {
        return array();
    }

    public function loadAllUnclaimedCards() {
        return array();
    }
}
?>