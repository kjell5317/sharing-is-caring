<?php
class Card {
    private $title;
    private $foodType;
    private $date;
    private $place;
    private $image;
    private $description;

    public function __construct($title, $foodType, $date, $place, $image, $description) {
        $this->title = $title;
        $this->foodType = $foodType;
        $this->date = $date;
        $this->place = $place;
        $this->image = $image;
        $this->description = $description;
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

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getPlace() {
        return $this->place;
    }

    public function setPlace($place) {
        $this->place = $place;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    if (isset($_POST['newEntry'])) {
        $title = $_POST['title'];
        $foodType = $_POST['foodType'];
        $date = $_POST['date'];
        $place = $_POST['place'];
        $image = $_POST['image'];
        $description = $_POST['description'];

        // Create a new instance of the Card class
        $card = new Card($title, $foodType, $date, $place, $image, $description);



    }

}

header("Location: ../meine-eintraege.php");
?>