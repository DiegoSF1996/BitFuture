<?php
if(!empty($_GET['controller']) && $_GET['method']){
    require 'App/Controllers/'.$_GET['controller'].'Controller.php';
    $controller = new ($_GET['controller'].'Controller')();
} else {
    $_GET['method'] = 'Index';
    require 'App/Controllers/IndexController.php';
    $controller = new IndexController;

}



