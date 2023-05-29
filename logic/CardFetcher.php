<?php
include_once "./Card.php";
include_once "./MainMemoryBasedCardDAO.php";
include_once "./usermanagement.php";

 $memory = MainMemoryBasedCardDAO::getInstance();

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    if (isset($_POST['newEntry'])) {
        $title = $_POST['title'];
        $foodType = $_POST['food-type'];
        $date = $_POST['expiration-date'];
        $place = $_POST['city'];
        $postalCode = $_POST['postal-code'];
        $image = $_POST['food-image'];
        $description = $_POST['description'];
        $creator = unserialize($_SESSION['loggedInUser']);

        // Create a new instance of the Card class
        $card = Card::getCardWithOwner($title, $foodType, $date, $place, $postalCode, $image, $description, $creator);
        $memory->saveCard($card);
        


    }

}

header("Location: ../meine-eintraege.php");
?>