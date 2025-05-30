<?php
require_once "./model/views_model.php";
class viewControl extends viewModel {
    public function getPlantillaControl(){
        return require_once "./view/plantilla.php";
    }
    public function getViewControl(){
        if (isset($_GET["views"])) {
            $ruta = explode("/", $_GET["views"]);
            $response = viewModel::get_view($ruta[0]);
        }else{
            $response = "index.php";
        }
        return $response;
    }
}
?>