<?php
session_start();

// константы для путей
define("ROOT", $_SERVER['DOCUMENT_ROOT']);
define("CONTROLLER_PATH", ROOT. "/controllers/");
define("MODEL_PATH", ROOT. "/models/");
define("VIEW_PATH", ROOT. "/views/");

/*print ROOT."<br>";
print CONTROLLER_PATH."<br>";
print MODEL_PATH."<br>";
print VIEW_PATH."<br>";*/

// подключение к БД
require_once("db.php");
// маршрутизация
require_once("route.php");

// общий файл модели
require_once MODEL_PATH.'Model.php';
// общий файл вьюхи
require_once VIEW_PATH.'View.php';
// общий файл контроллера
require_once CONTROLLER_PATH.'Controller.php';

// Composer
//require 'vendor/autoload.php';
//require_once("vendor/autoload.php");

// PHPSpreadsheet
//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

Routing::buildRoute();
