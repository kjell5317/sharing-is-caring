<?php
class DBBasedCardDAO implements CardDAO {

    private DBBasedCardDAO $instance; 

    public static function getInstance(): DBBasedCardDAO
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function saveCard(Card $card) {}

    public function loadCard() {
        return ;
    }

    public function loadCardsOfUser(User $user) {
        return;
    }
}
?>