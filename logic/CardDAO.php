<?php
interface CardDAO {
    public function saveCard(Card $card): bool;
    public function loadCard(): Card;
    public function loadCardsOfUser(User $user): array;
}
?>