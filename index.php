<?php
session_start();

require "config/autoload.php";

try {
    $router = new Router();
    $router->checkRoute();
    
} catch (Exception $e) {
    
    if($e->getCode() === 404)
    {
        require "./templates/404/404.phtml"; 
    }
}
?>