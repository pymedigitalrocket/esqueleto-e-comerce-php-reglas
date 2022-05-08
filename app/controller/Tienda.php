<?php

class Tienda extends Base{
    private $model;

    function __construct(){
        $this->model = $this->model("TiendaModel");
    }

    function caratula(){
        $sesion = new Sesion();
        $datas = $this->getMasVendidos();
        $nuevos = $this->getNuevos();
        $descuento = $this->getDescuento();
        $total = $this->model->totalProductos();
        $totalMasVendido = $this->model->totalMasVendido();
        $totalDescuento = $this->model->totalDescuento();
        $data = Caratula::caratula("Tienda Virtual", true, false, false, "Tienda Virtual", $datas);
        $dataDos = Caratula::caratulaPaginacion($data, $nuevos,$descuento,$total,$totalMasVendido,$totalDescuento);
        $this->view("tienda", $dataDos);
    }

    function logout() {
        session_start();
        if(isset($_SESSION["usuario"])){
            $sesion = new Sesion();
            $sesion->finalizarSesion();
        }
        header("Location:".RUTA);
    }

    function getMasVendidos(){
        $datas = array();
        $total = $this->model->totalMasVendido();
        if($total<=1){
            $total = 1;
        }else{
            $total = $total/4;
            $total = ceil($total);
        }
        $datasDos = Redundancia::paginacionController('masVendido',4,$total);
        $datas = $this->model->getMasVendidos($datasDos["limiteInicial"],4);
        return $datas;
    }

    function getNuevos(){
        $datas = array();
        $total = $this->model->totalProductos();
        if($total<=1){
            $total = 1;
        }else{
            $total = $total/4;
            $total = ceil($total);
        }
        $datasDos = Redundancia::paginacionController('pagina',4,$total);
        $datas = $this->model->getNuevos($datasDos["limiteInicial"],4);
        return $datas;
    }

    function getCategorias(){
        return $this->model->getLlaves("categoria");
    }

    function getTipoProducto($tipo){
        $sesion = new sesion();
        $totalCategoria = $this->model->totalCategoria($tipo);
        if($tipo==1){
            $categoria = "Vestidos";
        }else if($tipo==2){
            $categoria = "Poleras";
        }else if($tipo==3){
            $categoria = "Chaquetas";
        }else{
            $categoria = "Productos por categoria";
        }
        if($totalCategoria<=1){
            $total = 1;
        }else{
            $total = $totalCategoria/4;
            $total = ceil($total);
        }
        $datasDos = Redundancia::paginacionController('categoria',4,$total);
        $datas = $this->model->getTipoProducto($tipo, $datasDos["limiteInicial"], 4);
        $data = Caratula::caratula($categoria, true, false, false, "Tienda Virtual", $datas);
        $dataDos = Caratula::caratulaCategoria($data, $categoria, $totalCategoria, $tipo);
        $this->view("tipoProducto", $dataDos);
    }
    
    function getDescuento(){
        $datas = array();
        $total = $this->model->totalDescuento();
        if($total<=1){
            $total = 1;
        }else{
            $total = $total/4;
            $total = ceil($total);
        }
        $datasDos = Redundancia::paginacionController('descuento',4,$total);
        $datas = $this->model->getDescuento($datasDos["limiteInicial"],4);
        return $datas;
    }
}
?>