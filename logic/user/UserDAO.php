<?php
interface UserDAO
{
    public function createUser($email, $passowrd, $consent): bool;
    public function login($email): bool;
    public function logout(): bool;
    public function get(string $email): ?User;
}
?>