<?php require 'Login/sessions.php'; ?>
<?php require 'Core/Database/Database.php'; ?>
<?php require 'Core/helper.php'; ?>
<?php require 'Core/admin.php'; ?>
<?php require 'Core/router.php'; ?>
<?php 
    $router = new Route(); 
    $destination = $router->manage_routing();
    require($destination['path']);
    $controller = new $destination['classname'];
    $controller->executeAction(); 
?>
