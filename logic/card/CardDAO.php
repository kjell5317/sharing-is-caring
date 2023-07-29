<?php
interface CardDAO
{
    public function saveCard(Card $card);
    public function deleteCard();
    public function loadCard(string $id);
    public function claimCard();
    public function unclaimCard();
    public function updateCard(Card $card);
    public function loadAllCards(): array;
    public function loadAllUnclaimedCards(): array;
    public function loadUserClaimedCards(): array;
    public function loadUserCards(): array;
}
?>