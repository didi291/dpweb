<?php
require_once "./model/views_model.php";
class viewControl extends viewModel
{
    public function getPlantillaControl()
    {
        return require_once "./view/plantilla.php";
    }
    public function getViewControl()
    {
        session_start();
        if (isset($_SESSION['ventas_id'])){
            if (isset($_GET["views"])) {
            $ruta = explode("/", $_GET["views"]);
            $response = viewModel::get_view($ruta[0]);
        } else {
            $response = "index.php";
        } 
    } else {
            $response = "login";
    }
        return $response;
    }
}
