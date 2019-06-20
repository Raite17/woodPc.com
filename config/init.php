<?php

//Объявляем режимы, если 1 то это режим разработки,если 0 то режим PRODUCTION
define("DEBUG", 1);
//Корень приложения
define("ROOT", dirname(__DIR__));
//Указываем публичную папку
define("WWW", ROOT . '/public');
//Указываем  папку app
define("APP", ROOT . '/app');
//Указываем ядро приложения
define("CORE", ROOT . '/vendor/woodpc/core');
//Указываем папку libs
define("LIBS", ROOT . '/vendor/woodpc/core/libs');
//Указываем папку cache
define("CACHE", ROOT . '/tmp/cache');
//Указываем папку config
define("CONFIG", ROOT . '/config');
//Шаблон по умолчанию
define("LAYOUT", 'default');

//http://localhost/woodpc.com/public/index.php
$appPath = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";

//http://localhost/woodpc.com/public/
$appPath = preg_replace("#[^/]+$#", '', $appPath);

//http://localhost/woodpc.com
$appPath = str_replace('/public/', '', $appPath);

//BASE URL
define("PATH", $appPath);

//Админ панель
define("ADMIN", PATH . '/admin');

require_once ROOT . '/vendor/autoload.php';