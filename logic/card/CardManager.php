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

            if (inputsAreValid($foodType, $expdate, $image, $description, $postalCode, $city, $street, $number)) {
                $imagePath = $pathToImages . uniqid() . ".jpg";
                move_uploaded_file($image['tmp_name'], "../../" . $imagePath);

                $address = new Address(uniqid(), $postalCode, $city, $street, $number);
                $addr_id = $addressmanager->save($address);

                $card = new Card(uniqid(), $title, $foodType, $expdate, $addr_id, $imagePath, $description, unserialize($_SESSION['loggedInUser'])->id, null);
                // Create a new instance of the Card class
                $success = $cardmanager->saveCard($card);

                header("Location: meine-eintraege.php");
                exit;
            } else {
                header("Location: neuer-eintrag.php");
            }

        }

        if (isset($_POST['claim'])) {
            $cardmanager->claimCard();
        }
        if (isset($_POST['unclaim'])) {
            $cardmanager->unclaimCard();
        }
        if (isset($_POST['delete'])) {
            $cardmanager->deleteCard();
            header("Location: meine-eintraege.php");
            exit;
        }

    } else {
        $_SESSION['info'] = 'Melde dich an um Beiträge zu beanspruchen!';
        header("Location: anmeldung.php");
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

function inputsAreValid($foodType, $date, $image, $description, $postalCode, $city, $street, $number): bool
{
    if (!isValidFoodType($foodType)) {
        $_SESSION['info'] = "Nicht vorhandener Essenstyp angegeben";
        return false;
    }
    if (isDateBeforeToday($date)) {
        $_SESSION['info'] = "Stelle hier bitte keine abgelaufenen Lebensmittel ein";
        return false;
    }
    if (!imageValid($image)) {
        return false;
    }
    if (!is_string($description)) {
        $_SESSION['info'] = "Hoppla da ist wohl was schiefgelaufen mit der Beschreibung";
        return false;
    }
    if (!isPostalCode($postalCode)) {
        $_SESSION['info'] = "Du muss eine deutsche Postleitzahl bestehend aus 5 Ziffern eingeben";
        return false;
    }
    if (!is_string($city) || !is_string($street) || !is_string($number)) {
        $_SESSION['info'] = "Hoppla da ist wohl was schiefgelaufen, überprüfe nochmal genau deine Adresse";
        return false;
    }
    return true;
}

function isValidFoodType($type)
{
    $types = array("Vegan", "Vegetarisch", "Schwein", "Fleisch", "Getränk", "Anderes");
    return in_array($type, $types);
}

function isDateBeforeToday($date): bool
{
    $submittedDate = DateTime::createFromFormat('Y-m-d', $date);
    $today = new DateTime('yesterday');
    if ($today >= $submittedDate) {
        return true;
    } else {
        return false;
    }
}

function imageValid($image): bool
{
    if ($image['size'] > 5000000) {
        $_SESSION['info'] = "Bild ist zu groß";
        return false;
    }
    $imageFileType = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        $_SESSION['info'] = "Nur gif,png,jpg und jpeg Bilder sind erlaubt";
        return false;
    }
    return true;
}

function isPostalCode($postalCode): bool
{
    //ChatGPT
    $pattern = '/^\d{5}$/';
    return preg_match($pattern, $postalCode) === 1;
}

?>