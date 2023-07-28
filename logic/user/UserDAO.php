<?php
interface UserDAO
{
    public function createUser(string $email, string $passowrd, int $consent): bool;
    public function login($email): bool;
    public function logout(): bool;
    public function get(string $email): ?User;
}
?>