<?php 
class Card {
    public $id;
    public $title;
    public $foodType;
    public $expirationDate;
    public $imagePath;
    public $description;
    public $addr_id;
    public $claimer;
    public $owner;

    public function __construct($id, $title, $foodType, $expdate, $addr_id, $imagePath, $description, $owner, $claimer)
    {
        $this->id = $id;
        $this->title = $title;
        $this->foodType = $foodType;
        $this->expirationDate = $expdate;
        $this->addr_id = $addr_id;
        $this->imagePath = $imagePath;
        $this->description = $description;
        $this->owner = $owner;
        $this->claimer = $claimer;
    }
}
?>