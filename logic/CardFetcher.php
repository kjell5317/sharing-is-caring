<?php 
include_once "../logic/SQLAddressDAO.php";
include_once "../logic/Database.php";
include_once "SQLCardDAO.php";
include_once "UserManagement.php";
include_once "Database.php";

$pathToImages = "tmp/images/";
$db = Database::getInstance();
$conn = $db->getDatabase();
$cardmanager = new SQLCardDAO($conn);
$addressmanager = new SQLAddressDAO($conn);

if (isset($_GET['numberOfCards'])) {
    $numberOfCards = $_GET['numberOfCards'];
    $cards = $cardmanager->loadUnclaimedCardsSequential($numberOfCards);
    foreach($cards as $card) {
        $card = unserialize($card);
        include "../components/card.php";
    }
}


?>