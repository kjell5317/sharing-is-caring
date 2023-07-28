<?php
class User
{
    public int $id;
    public string $email;
    public string $password;
    public int $validated;
    public int $consent;

    public function __construct($id, $email, $password, $validated, $consent)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->validated = $validated;
        $this->consent = $consent;
    }
}
?>