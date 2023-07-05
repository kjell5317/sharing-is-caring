<?php
class User
{
    public $id;
    public $email;
    public $password;
    public $validated;

    public function __construct($id, $email, $password, $validated)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->validated = $validated;
    }
}
?>