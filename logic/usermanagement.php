<?php
include_once "SessionUserDAO.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usermanager = new SessionUserDAO();
    /*
     * Anfrage ist eine Registrierung
     */
    if (isset($_POST['register'])) {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $repassword = $_POST['repassword'] ?? '';

        $usermanager->createUser($email, $password, $repassword);
    } 
    /*
    * Anfrage ist ein Login
    */
    if (isset($_POST['login'])) {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $usermanager->login($email, $password);
    }
}

if (isset($_GET['logout'])) {
    $usermanager = new SessionUserDAO();
    $usermanager->logout();
}

$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);

?>