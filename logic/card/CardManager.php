<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/sharing-is-caring/logic/sqlDAO/SQLCardDAO.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/sharing-is-caring/logic/user/UserManagement.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/sharing-is-caring/logic/sqlDAO/SQLAddressDAO.php";

$pathToImages = "tmp/images/";

$cardmanager = new SQLCardDAO();
$addressmanager = new SQLAddressDAO();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['loggedInUser'])) {
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

            $imagePath = $pathToImages . uniqid() . ".jpg";
            move_uploaded_file($image['tmp_name'], "../../" . $imagePath);

            $address = new Address(uniqid(), $postalCode, $city, $street, $number);
            $addr_id = $addressmanager->save($address);

            $card = new Card(uniqid(), $title, $foodType, $expdate, $addr_id, $imagePath, $description, unserialize($_SESSION['loggedInUser'])->id, null);
            // Create a new instance of the Card class
            $success = $cardmanager->saveCard($card);

            header("Location: ../../meine-eintraege.php");
            exit;

        }

        if (isset($_POST['claim'])) {
            $cardmanager->claimCard();
        }
        if (isset($_POST['unclaim'])) {
            $cardmanager->unclaimCard();
        }

    } else {
        $_SESSION['info'] = 'Melde dich an um Beiträge zu beanspruchen!';
        header("Location: ../../anmeldung.php");
        exit;
    }
} else if (isset($_GET['numberOfCards'])) {
    if (isset($_GET['search']) && !empty($_GET['search'] && $_GET['search'] !== "null")) {
        $cards = $cardmanager->queryUnclaimedCardsSequential($_GET["numberOfCards"], $_GET['search']);
    } else {
        $cards = $cardmanager->loadUnclaimedCardsSequential($_GET["numberOfCards"]);
    }
    foreach ($cards as $card) {
        $card = unserialize($card);
        include $_SERVER['DOCUMENT_ROOT'] . "/sharing-is-caring/components/card.php";
    }
}

?>