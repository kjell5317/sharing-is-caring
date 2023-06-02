<?php
interface CardDAO {
    public function saveCard($title, $foodType, $expirationDate, $place, $postalCode, $imagePath, $description, $claimed, $owner);
    public function loadCard($id): Card;
    public function claimCard();
    public function unclaimCard();
    public function updateCard($id, $card);
    public function loadAllCards(): array;
    public function loadAllUnclaimedCards(): array;
}
?>