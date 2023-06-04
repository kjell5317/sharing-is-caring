<?php
include_once "SQLCardDAO.php";
include_once "UserManagement.php";
include_once "SQLAddressDAO.php";

$pathToImages = "tmp/images/";
$cardmanager = new SQLCardDAO();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['newEntry'])) {
        $addressmanager = new SQLAddressDAO();

        $title = $_POST['title'];
        $foodType = $_POST['food-type'];
        $expdate = $_POST['expiration-date'];
        $image = $_FILES['food-image'];
        $description = $_POST['description'];

        $postalCode = $_POST['postal-code'];
        $city = $_POST['city'];
        $street = $_POST['street'];
        $number = $_POST['number'];

        $pathToImages = "tmp/images/";
        $imagePath = $pathToImages . basename($image['name']);
        while (file_exists($imagePath)) {
            $imagePath = $pathToImages . strval(rand(2000000)) . basename(($image['name'])); // give kinda random name to image if an image with existing name is uploaded;
        }
        move_uploaded_file($image['tmp_name'], "../" . $imagePath);

        $address = new Address(random_int(10000, 99999), $postalCode, $city, $street, $number);
        $addr_id = $addressmanager->save($address);

        $card = new Card(random_int(10000, 99999), $title, $foodType, $expdate, $addr_id, $imagePath, $description, unserialize($_SESSION['loggedInUser'])->email, null);
        // Create a new instance of the Card class
        $success = $cardmanager->saveCard($card);
        
        header("Location: ../meine-eintraege.php");
        exit;

    }

    if (isset($_POST['claim'])) {
        $cardmanager->claimCard();
    }
    if (isset($_POST['unclaim'])) {
        $cardmanager->unclaimCard();
    }
}

?>