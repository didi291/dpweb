<?php
require_once "./config/config.php";
require_once "./control/views_control.php";

$view = new viewControl();
$mostrar = $view->getViewControl();

if ($mostrar == "login" || $mostrar == "404") {
    require_once "./view/".$mostrar.".php";
}else{
    include $mostrar;
}