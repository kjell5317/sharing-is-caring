<?php 
class Card {
    public $id;
    public $title;
    public $foodType;
    public $expirationDate;
    public $place;
    public $postalCode;
    public $imagePath;
    public $description;
    public bool $claimed;
    public User $owner;
}
?>