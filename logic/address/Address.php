<?php 
class Address {
    public $id;
    public $postalCode;
    public $city;
    public $street;
    public $number;

    public function __construct($id, $postalCode, $city, $street, $number)
    {
        $this->id = $id;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->street = $street;
        $this->number = $number;
    }
}
?>