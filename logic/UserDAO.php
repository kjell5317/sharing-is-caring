<?php
interface UserDAO
{
    public function createUser($email, $passowrd);
    public function loadClaimedCards(): array;
    public function loadCards(): array;
    public function login($email, $password);
    public function logout();
    public function get($email);
}
?>