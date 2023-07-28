<?php
include_once "logic/address/Address.php";
include_once "logic/address/AddressDAO.php";

class SessionAddressDAO implements AddressDAO
{

    public function save($address)
    {
        $_SESSION['addresses'][$address->id] = serialize($address);
        return $address->id;
    }

    public function get($id)
    {
        if (isset($_SESSION['addresses'][$id])) {
            return unserialize($_SESSION['addresses'][$id]);
        }
        return null;
    }
}
?>