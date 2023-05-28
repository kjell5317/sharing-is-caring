<?php
class MainMemoryBasedCardDAO implements CardDAO {

    private MainMemoryBasedCardDAO $instance;

    public static function getInstance(): MainMemoryBasedCardDAO
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {}
    public function saveCard(Card $card) {
        return true;
    }

    public function loadCard() {
        return ;
    }

    public function loadCardsOfUser(User $user) {
        return;
    }
}
?>