<?php
//*Iniciamos la session
session_start();
//*Saber si estamos en servidor local
define('IS_LOCAL', in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']));

$web_url = IS_LOCAL ? 'http://127.0.0.1:8848/coti/' : 'LA URL DE SERVIDOR EN PRODUCCION';
define('URL', $web_url);

//*Rutas para carpetas
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', getcwd() . DS);
define('APP', ROOT . 'app' . DS);
define('ASSETS', ROOT . 'assets' . DS);
define('TEMPLATES', ROOT . 'templates' . DS);
define('UPLOADS', 'assets/uploads/');
define('INCLUDES', TEMPLATES . 'includes' . DS);
define('MODULES', TEMPLATES . 'modules' . DS);
define('VIEWS', TEMPLATES . 'views' . DS);

//*Para archivos que vayan en el header o footer (CSS O JS)
define('CSS', URL . 'assets/css/');
define('IMG', URL . 'assets/img/');
define('JS', URL . 'assets/js/');

//* Personalizacion 
define('APP_NAME', 'S.I.C.O.T');
define('TAX_RATE', 7); //!ES UN PORCENTAJE

//* Autoload Composer
require_once ROOT . 'vendor/autoload.php';

//*Cargar todas las funciones
require_once APP . 'functions.php';
