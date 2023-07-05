<?php 
class Card {
    public $id;
    public $title;
    public $foodType;
    public $expirationDate;
    public $imagePath;
    public $description;
    public $adr_id;
    public $claimer;
    public $owner;

    public function __construct($id, $title, $foodType, $expdate, $adr_id, $imagePath, $description, $owner, $claimer)
    {
        $this->id = $id;
        $this->title = $title;
        $this->foodType = $foodType;
        $this->expirationDate = $expdate;
        $this->adr_id = $adr_id;
        $this->imagePath = $imagePath;
        $this->description = $description;
        $this->owner = $owner;
        $this->claimer = $claimer;
    }
}
?>