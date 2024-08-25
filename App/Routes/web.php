<?php
require_once 'App/Helpers/Routes.php';

Routes::addRoute('', 'App/Controllers/IndexController.php', 'index','GET');
Routes::addRoute('index', 'App/Controllers/IndexController.php', 'index','GET');

