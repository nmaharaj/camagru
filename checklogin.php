<?php

session_start();
if (!isset($_SESSION["email"]))
{
    header ('location: http://localhost:8080/camagru/login.phtml');
}

?>