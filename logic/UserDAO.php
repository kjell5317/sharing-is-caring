<?php
interface UserDAO
{
    public function createUser($email, $passowrd, $repassword);
    public function loadClaimedCards(): array;
    public function loadCards(): array;
    public function login($email, $password);
    public function logout();
}
?>