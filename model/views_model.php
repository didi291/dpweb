<?php
class viewModel {//decla la clase viewModel que contiene las funciones para manejar las vistas
    protected static function get_view($view){//define una funcion estatica protegida llamada get_view que recibe un nombre de vista
        $white_list = ["login", "home", "new-product", "products", "edit-products", "users","category", "new-user", "edit-user", "new-categoria","edit-category",];//lista blanca de vistas permitidas
        if (in_array($view, $white_list)) {//verifica si la vista solicitada esta en la lista blanca
            //si el archivo existe en la carpeta view/ guarda su ruta en content. si no existe guarda "404" en content
            if (is_file("./view/".$view.".php")) {
                $content = "./view/".$view.".php";
            }else{
                $content = "404";
            }
            //excepcion redundante, si la vista es login vueolve a asignar login a content, aunque ya esta en la lista blanca, podria eliminarse, pero no causa errores
        }elseif ($view == "login") {
            $content = "login";
        //si la vista no esta en la lista blanca y no es login, asigna "404" a content
        }else{
            $content = "404";
        }
        return $content;
    }
}
?>