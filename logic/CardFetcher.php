<?php
include_once "./Card.php";
include_once "./SessionBasedCardDAO.php";
include_once "./usermanagement.php";

 $memory = SessionBasedCardDAO::getInstance();

$pathToImages = "tmp/images/";
if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    if (isset($_POST['newEntry'])) {
        $title = $_POST['title'];
        $foodType = $_POST['food-type'];
        $date = $_POST['expiration-date'];
        $place = $_POST['city'];
        $postalCode = $_POST['postal-code'];

        $image = $_FILES['food-image'];
        $imagePath = $pathToImages . basename($image['name']);
        while(file_exists($imagePath)) {
            $imagePath = $pathToImages . strval(rand(2000000)) . basename(($image['name'])); // give kinda random name to image if an image with existing name is uploaded;
        }
        move_uploaded_file($image['tmp_name'],"../" . $imagePath);
        $description = $_POST['description'];
        $creator = unserialize($_SESSION['loggedInUser']);

        // Create a new instance of the Card class
        $card = Card::getCardWithOwner($title, $foodType, $date, $place, $postalCode, $imagePath, $description, $creator);
       if($memory->saveCard($card)) {
        header("Location: ../meine-eintraege.php");
       } else  {
        echo "Hoppla da ist wohl etwas schief gelaufen";
       }
        


    }

}

?>