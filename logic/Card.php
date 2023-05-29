<?php 
class Card {
    public $title;
    public $foodType;
    public $expirationDate;
    public $place;
    public $postalCode;
    public $imagePath;
    public $description;
    public bool $claimed = false;
    public User $owner;

    public static function getCardWithoutOwner($title, $foodType, $expirationDate, $place, $postalCode, $imagePath, $description): Card
    {
        $instance = new self();
        $instance->setTitle($title);
        $instance->setFoodType($foodType);
        $instance->setExpirationDate($expirationDate);
        $instance->setPlace($place);
        $instance->setPostalCode($postalCode);
        $instance->setImagePath($imagePath);
        $instance->setDescription($description);
        return $instance;
    }

    public static function getCardWithOwner($title, $foodType, $expirationDate, $place, $postalCode, $imagePath, $description, User $owner): Card {
        $instance = self::getCardWithoutOwner($title, $foodType, $expirationDate, $place, $postalCode, $imagePath, $description);
        $instance->setOwner($owner);
        return $instance;
    }

    public static function getEmptyCard() {
        return new self();
    }

    private function __construct() {
    }

    // Getters and setters for the attributes
    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getFoodType() {
        return $this->foodType;
    }

    public function setFoodType($foodType) {
        $this->foodType = $foodType;
    }

    public function getExpirationDate() {
        return $this->expirationDate;
    }

    public function setExpirationDate($expirationDate) {
        $this->expirationDate = $expirationDate;
    }

    public function getPlace() {
        return $this->place;
    }

    public function setPlace($place) {
        $this->place = $place;
    }

    public function getPostalCode() {
         return $this->postalCode;
    }

    public function setPostalCode($postalCode) {
         $this->postalCode = $postalCode;
    }

    public function getImagePath() {
        return $this->imagePath;
    }

    public function setImagePath($image) {
        $this->imagePath = $image;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function claim() {
        $this->claimed = true;
    }

    public function unclaim() {
        $this->claimed = false;
    }

    public function isClaimed() {
        return $this->claimed;
    }

    public function getOwner() {
        return $this->owner;
    }

    public function setOwner(User $owner) {
        $this->owner = $owner;
    }

}
?>