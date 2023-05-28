<?php 
class Card {
    private $title;
    private $foodType;
    private $expirationDate;
    private $place;
    private int $postalCode;
    private $imagePath;
    private $description;

    public function __construct($title, $foodType, $expirationDate, $place, $postalCode, $imagePath, $description) {
        $this->title = $title;
        $this->foodType = $foodType;
        $this->expirationDate = $expirationDate;
        $this->place = $place;
        $this->imagePath = $imagePath;
        $this->description = $description;
        $this->postalCode = $postalCode;
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

    public function setDate($expirationDate) {
        $this->expirationDate = $expirationDate;
    }

    public function getPlace() {
        return $this->place;
    }

    public function setPlace($place) {
        $this->place = $place;
    }

    public function getPostalCode(int $postalCode) {
         $this->postalCode = $postalCode;
    }

    public function setPostalCode() {
        return $this->postalCode;
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

    public function getHTMLCode() {
        $html = '
        <div class="card">
            <link rel="stylesheet" href="css/Card.css"/>
            <img class="photo" src="'.htmlentities($this->imagePath).'"/>
            <h1>' . htmlentities($this->title) .'</h1>
            <p class="category">'. htmlentities($this->foodType).'</p>
            <p class="mhd">'.htmlentities($this->expirationDate).'</p>
            <p class="ort">'.htmlentities($this->postalCode.' '. $this->place).'</p>
            <a class="weiter" href="eintrag.php">
                <p style="margin: 0;">Zeig mir mehr</p>
                <img src="assets/arrow.svg" class="arrow" />
            </a>
         </div>
     ';
     return $html;
    }
}
?>