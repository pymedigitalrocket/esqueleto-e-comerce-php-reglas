<?php

class SobreNosotros extends base{

    function __construct(){}

    function caratula(){
        $sesion = new Sesion();
        $data = Caratula::caratula("Sobre nosotros", true, false, false, "Tienda Virtual");
        $dataDos = Caratula::caratulaActivo($data, "sobreNosotros");
        $this->view("sobreNosotros", $dataDos);
    }
}
?>