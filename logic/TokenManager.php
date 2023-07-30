<?php

function getCSRFToken(): string
{
    if(isset($_SESSION['loggedInUser'])) {
        if(isset($_SESSION[$_SESSION['loggedInUser']]['security_token'])) {
            return $_SESSION[$_SESSION['loggedInUser']]['security_token'];
        } else {
            return "";
        }
    }
}

function generateCSRFToken()
{
    if(isset($_SESSION['loggedInUser'])) {
        if (empty($_SESSION[$_SESSION['loggedInUser']]['security_token'])) {
            $token = bin2hex(random_bytes(32));
            $_SESSION[$_SESSION['loggedInUser']]['security_token'] = $token;
        }
    }
}


function validateToken($token) : bool 
{
    return getCSRFToken() == $token;
}

?>