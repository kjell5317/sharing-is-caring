<?php 
include_once "Card.php";
include_once "SQLAddressDAO.php";

function htmlOfCard(Card $card) {
    $db = Database::getInstance();
    $conn = $db->getDatabase(); 
    $addressmanager = new SQLAddressDAO($conn);
    $html = '
    <div class="card">
        <link rel="stylesheet" href="css/Card.css"/>
        <img class="photo" src="'.htmlentities($card->imagePath).'"/>
        <h1>' . htmlentities($card->title) .'</h1>
        <p class="category">'. htmlentities($card->foodType).'</p>
        <p class="mhd">'.htmlentities($card->expirationDate).'</p>
        <p class="ort">'.htmlentities($addressmanager->get($card->addr_id)->postalCode.' '. $addressmanager->get($card->addr_id)->city).'</p>
        <a class="weiter" href="eintrag.php?id='.htmlentities($card->id).'">
            <p style="margin: 0;">Zeig mir mehr</p>
            <img src="assets/arrow.svg" class="arrow" />
        </a>
     </div>
 ';
 return $html;
}

function htmlOfCards(array $cards) {
    $html = "";
    foreach($cards as $card) {
        $html = $html . "\n" . htmlOfCard(unserialize($card));
    }
    return $html;
}

?>