<?php 
include_once "Database.php";
include_once "../SQLAddressDAO.php";
include_once "../SQLCardDAO.php";
include_once "../UserManagement.php";

$pathToImages = "tmp/images/";

//answers the xmlHttpRequest with the html of the requested Number Of Cards
if (isset($_GET['numberOfCards'])) {
    $db = Database::getInstance();
    $conn = $db->getDatabase();
    $cardmanager = new SQLCardDAO($conn);
    $addressmanager = new SQLAddressDAO($conn);

    $numberOfCards = $_GET['numberOfCards'];
    $cards = $cardmanager->loadUnclaimedCardsSequential($numberOfCards);
    foreach($cards as $card) {
        $card = unserialize($card);
        include "../../components/card.php";
    }
}


?>