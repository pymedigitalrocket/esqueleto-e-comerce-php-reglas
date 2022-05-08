<?php

class AdminInicio extends Base{
    private $model;

    function __construct(){
        $this->model = $this->model("AdminInicioModel");
    }

    function caratula() {
        $sesion = new Sesion();
        if($sesion->getLogin()){
            $data = Caratula::caratula("Perfil Administrativo", false, true, false, "Admin");
            $this->view("inicioAdmin", $data);
        }else{
            header("Location:".RUTA."loginAdmin");
        }
    }
}
?>