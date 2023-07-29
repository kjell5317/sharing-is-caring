<?php

function getCSRFToken(): string
{
    if (empty($_SESSION['security_token'])) {
        $token = bin2hex(random_bytes(32));
        $_SESSION['security_token'] = $token;
        return $token;
    } else {
        return $_SESSION['security_token'];
    }
}


function validateToken($token) : bool 
{
    return $_SESSION['security_token'] == $token;
}



?>