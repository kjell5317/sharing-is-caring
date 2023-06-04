<?php
interface CardDAO {
    public function saveCard($card);
    public function loadCard($id);
    public function claimCard();
    public function unclaimCard();
    public function updateCard($card);
    public function loadAllCards(): array;
    public function loadAllUnclaimedCards(): array;
    public function loadUserClaimedCards(): array;
    public function loadUserCards(): array;
}
?>