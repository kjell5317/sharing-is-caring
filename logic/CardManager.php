<?php
include_once "SQLCardDAO.php";
include_once "UserManagement.php";
include_once "SQLAddressDAO.php";
include_once "Database.php";

$pathToImages = "tmp/images/";
$db = Database::getInstance();
$conn = $db->getDatabase();
$cardmanager = new SQLCardDAO($conn);
$addressmanager = new SQLAddressDAO($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['newEntry'])) {
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
        $imagePath = $pathToImages . basename($image['name']) . uniqid();
        move_uploaded_file($image['tmp_name'], "../" . $imagePath);

        $address = new Address(uniqid(), $postalCode, $city, $street, $number);
        $addr_id = $addressmanager->save($address);

        $card = new Card(uniqid(), $title, $foodType, $expdate, $addr_id, $imagePath, $description, unserialize($_SESSION['loggedInUser'])->id, null);
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