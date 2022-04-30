<?php

session_start();

// Общие настройки
ini_set('display_errors', 1);
// error_reporting(E_ALL);

// Подключение файлов системы
define('ROOT', dirname(__FILE__));
require_once(ROOT.'/components/Autoload.php');

// Вызов Routeer
$router = new Router();
$router->run();