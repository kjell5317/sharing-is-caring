<?php
include "Card.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    if (isset($_POST['newEntry'])) {
        $title = $_POST['title'];
        $foodType = $_POST['foodType'];
        $date = $_POST['date'];
        $place = $_POST['place'];
        $postalCode = $_POST['postalCode'];
        $image = $_POST['image'];
        $description = $_POST['description'];
        $creator = unserialize($_SESSION['loggedInUser']);

        // Create a new instance of the Card class
        $card = Card::getCardWithOwner($title, $foodType, $date, $place, $postalCode, $image, $description,$creator);



    }

}

header("Location: ../meine-eintraege.php");
?>