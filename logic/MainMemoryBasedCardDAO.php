<?php
include_once "CardDAO.php";
include_once "Card.php";
include_once "CardController.php";
include_once "usermanagement.php";
class MainMemoryBasedCardDAO implements CardDAO {

    private static $cards;
    private static $instance;

    public static function getInstance(): MainMemoryBasedCardDAO
    {
        if (self::$instance === null) {
            self::$instance = new self();
            self::$cards = array();
        }

        return self::$instance;
    }

    private function __construct() {}
    public function saveCard(Card $card):bool {
        $store = fopen("../tmp/cards.json", "a+") or die("Failed to load File");
        $txt = json_encode($card);
        fwrite($store, $txt);
        fwrite($store, "\n");
        fclose($store);
        return true;
    }

    public function loadCard(): Card {
        $filePath = "./tmp/cards.json";
    if (file_exists($filePath)) {
        $file = fopen($filePath, "r") or die("Failed to load File");
        $txt = fgets($file);
        fclose($file);
        $card = json_decode($txt, true);
        $cardOwner = new User;
        $cardOwner->email = $card["owner"]["email"];
        $card = Card::getCardWithOwner($card["title"],$card["foodType"],$card["expirationDate"],$card["place"], $card["postalCode"],$card["imagePath"],$card["description"],$cardOwner);
        return $card;
    } else {
        echo "Error: File not found";
        return Card::getEmptyCard();
    }
      }
    
    

    public function loadCardsOfUser(User $user):array {
        return array();
    }

    public function loadAllCards() {
         $filePath = "./tmp/cards.json";
        if(file_exists($filePath)) {
            $file = fopen($filePath, "r") or die ("Failed to load File");
            $back = array();
            while(!feof($file)) {
                $txt = fgets($file);
                if (!($txt == "")) {
                    $card = json_decode($txt, true);
                    $cardOwner = new User;
                    $cardOwner->email = $card["owner"]["email"];
                    $card = Card::getCardWithOwner($card["title"],$card["foodType"],$card["expirationDate"],$card["place"], $card["postalCode"],$card["imagePath"],$card["description"],$cardOwner);   
                    $back[] = $card;
                }                    
            }
            fclose($file);
            return $back;
        } else  {
            echo "Error: Cards not found";
            return array();
        }
    }

    public function loadAllUnclaimedCards(): array {
        return array();
    }
}
?>