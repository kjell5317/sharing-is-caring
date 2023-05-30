<?php 
include_once "Card.php";
function htmlOfCard(Card $card) {
    $html = '
    <div class="card">
        <link rel="stylesheet" href="css/Card.css"/>
        <img class="photo" src="'.htmlentities($card->getImagePath()).'"/>
        <h1>' . htmlentities($card->getTitle()) .'</h1>
        <p class="category">'. htmlentities($card->getFoodType()).'</p>
        <p class="mhd">'.htmlentities($card->getExpirationDate()).'</p>
        <p class="ort">'.htmlentities($card->getPostalCode().' '. $card->getPlace()).'</p>
        <a class="weiter" href="eintrag.php">
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
        $html = $html . "\n" . htmlOfCard($card);
    }
    return $html;
}

?>