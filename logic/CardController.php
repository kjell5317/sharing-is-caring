<?php 
include_once "MainMemoryBasedCardDAO.php";
$memory = MainMemoryBasedCardDAO::getInstance();


function getARandomCard() {
    global $memory;
    return $memory->loadCard()->getHTMLCode();
}


?>