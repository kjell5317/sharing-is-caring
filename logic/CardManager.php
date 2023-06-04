<?php
include_once "SessionCardDAO.php";
include_once "UserManagement.php";

$pathToImages = "tmp/images/";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['newEntry'])) {
        $title = $_POST['title'];
        $foodType = $_POST['food-type'];
        $expdate = $_POST['expiration-date'];
        $place = $_POST['city'];
        $postalCode = $_POST['postal-code'];

        $image = $_FILES['food-image'];
        $description = $_POST['description'];

        // Create a new instance of the Card class
        $cardmanager = new SessionCardDAO();
        $cardmanager->saveCard($title, $foodType, $expdate, $place, $postalCode, $image, $description, false, $_SESSION["loggedInUser"]);

        header("Location: ../meine-eintraege.php");
        exit;
    }

    if (isset($_POST['claim'])) {
        $cardmanager = new SessionCardDAO();
        $cardmanager->claimCard();
    }
    if (isset($_POST['unclaim'])) {
        $cardmanager = new SessionCardDAO();
        $cardmanager->unclaimCard();
    }
}

?>