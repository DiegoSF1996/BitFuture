<?php
require 'App/Routes/web.php';

$requestUri = $_SERVER['REQUEST_URI'];
$requestUri = substr($requestUri, 1);
Routes::callRoute($requestUri);
