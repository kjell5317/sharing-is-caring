<?php
interface UserDAO
{
    public function createUser($email, $passowrd) : bool;
    public function login($email) : bool;
    public function logout() : bool;
    public function get($email);
}
?>