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

    public function saveCard(Card $card):bool {}

    public function loadCard():Card {
        
    }

    public function loadCardsOfUser(User $user) {
       
    }
}
?>