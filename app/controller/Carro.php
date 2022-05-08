<?php

class Carro extends Base{
    private $model;

    function __construct(){
        $this->model = $this->model("CarroModel");
    }

    function caratula($errores=[]){
        $sesion = new Sesion();
        if(isset($_SESSION["usuario"])){
            $idUsuario = $_SESSION["usuario"]["id"];
            $datas = $this->model->getCarro($idUsuario);
            $data = Caratula::caratula("Carro de compras", true, false, false, "Tienda Virtual", $datas, $errores);
            $dataDos = Caratula::caratulaId($data, $idUsuario);
            $this->view("carro", $dataDos);
        }else{
            $idTemporal = $_SESSION["temporal"];
            $datas = $this->model->getCarro($idTemporal);
            $data = Caratula::caratula("Carro de compras", true, false, false, "Tienda Virtual", $datas, $errores);
            $dataDos = Caratula::caratulaId($data, $idTemporal);
            $this->view("carro", $dataDos);
        }
    }

    function agregarProducto($id, $idUsuario){
        $errores = array();
        if($this->model->verificarProducto($id, $idUsuario)==false){
            if($this->model->agregarProducto($id, $idUsuario)==false){
                array_push($errores, "no queda stock (en el icono del correo, puede pedirnos mas stock o un pedido personalizado de ese producto)");
            }
        }
        $this->caratula($errores);
    }

    function actualizar() {
        $errores = array();
        if(isset($_POST["num"]) && isset($_POST["idUsuario"])){
            $num = $_POST["num"];
            $idUsuario = $_POST["idUsuario"];
            for($i=0;$i<$num;$i++){
                $idProducto = $_POST["i".$i];
                $cantidad = $_POST["c".$i];
                if(!$this->model->actualizar($idUsuario, $idProducto, $cantidad)){
                    array_push($errores, "no queda stock suficiente (en el icono del correo, puede pedirnos mas stock o un pedido personalizado de ese producto)");
                }
            }
            $this->caratula($errores);
        }
    }

    function borrar($idProducto, $idUsuario){
        $errores = array();
        if(!$this->model->borrar($idProducto, $idUsuario)){
            array_push($errores, "Error al borrar el producto");
        }
        $this->caratula($errores);
    }

    function checkout(){
        $sesion = new Sesion();
        if(isset($_SESSION["usuario"])){
            $datas = $_SESSION["usuario"];
            $data = Caratula::caratula("Datos de envio", true, false, false, "Tienda Virtual", $datas);
            $this->view("datosEnvio", $data);
        }else{
            $data = Caratula::caratula("Datos de envio", true, false, false, "Tienda Virtual");
            $this->view("datosEnvio", $data);
        }
    }

    function formaPago(){
        $sesion = new Sesion();
        if(isset($_SESSION["usuario"])){
            $this->insertarTemporal();
            $data = Caratula::caratula("Forma de pago", true, false, false, "Tienda Virtual");
            $this->view("formaPago", $data);
        }else{
            $this->insertarTemporal();
        }
    }

    function verificar(){
        $sesion = new Sesion();
        $pago = isset($_POST["pago"])?$_POST["pago"] :"";
        if(isset($_SESSION["usuario"])){
            $datas = $_SESSION["usuario"];
            $idUsuario = $_SESSION["usuario"]["id"];
            $carro = $this->model->getCarro($idUsuario);
            $data = Caratula::caratula("Verificar datos", true, false, false, "Tienda Virtual", $datas);
            $dataDos = Caratula::caratulaCarro($data, $pago, $carro);
            $this->view("verificar", $dataDos);
        }else{
            $datas = $this->model->getIDTemporal();
            $idTemporal = $_SESSION["temporal"];
            $carro = $this->model->getCarro($idTemporal);
            $data = Caratula::caratula("Verificar datos", true, false, false, "Tienda Virtual", $datas);
            $dataDos = Caratula::caratulaCarro($data, $pago, $carro);
            $this->view("verificar", $dataDos);
        }
    }

    function gracias(){
        $sesion = new Sesion();
        if(isset($_SESSION["usuario"])){
            $datas = $_SESSION["usuario"];
            $idUsuario = $_SESSION["usuario"]["id"];
            $datasDos = $this->model->getGracias($idUsuario);
            $datasTres = $this->model->getCarro($idUsuario);
            $this->model->enviarCorreo($datas, $datasTres);
            if($this->model->cierraCarro($idUsuario, 1)){
                for($i=0; $i<count($datasDos); $i++){
                    $idProducto = $datasDos[$i]["id_producto"];
                    $cantidad = $datasDos[$i]["cantidad"];
                    $this->model->actualizarMasVendido($idProducto, $cantidad);
                    if(STOCK){
                        $this->model->actualizarStock($idProducto, $cantidad);
                    }
                }
                $data = Caratula::caratula("Gracias por su compra", true, false, false, "Tienda Virtual", $datas);
                $this->model->compraEfectiva("usuario logeado");
                $this->view("gracias", $data);
            } 
        }else{
            $idTemporal = $_SESSION["temporal"];
            $datas = $this->model->getIDTemporal();
            $datasDos = $this->model->getGracias($idTemporal);
            $datasTres = $this->model->getCarro($idTemporal);
            $this->model->enviarCorreo($datas, $datasTres);
            if($this->model->cierraCarro($idTemporal, 1)){
                for($i=0; $i<count($datasDos); $i++){
                    $idProducto = $datasDos[$i]["id_producto"];
                    $cantidad = $datasDos[$i]["cantidad"];
                    $this->model->actualizarMasVendido($idProducto, $cantidad);
                    if(STOCK){
                        $this->model->actualizarStock($idProducto, $cantidad);
                    }
                }
                $data = Caratula::caratula("Gracias por su compra", true, false, false, "Tienda Virtual", $datas);
                $this->model->compraEfectiva("usuario temporal");
                $this->view("gracias", $data);
            } 
        }
    }

    function ventas() {
        $sesion = new Sesion();
        $total = 0;
        $categorias = $this->model->getLlaves("categoria");
        if($sesion->getLogin()){
            if($_SERVER['REQUEST_METHOD'] == "GET"){
                $errores = array();
                $datasDos = Redundancia::validacionFiltros();
                $errores = $datasDos["errores"];
                $fechaInicio = $datasDos["datas"]['fechaInicio'];
                $fechaMaxima = $datasDos["datas"]['fechaMaxima'];
                $productos = $datasDos["datas"]['productos'];
                $categoria = $datasDos["datas"]['categoria'];
                if(empty($errores)){
                    $totalVentas = $this->model->totalVentas($fechaInicio,$fechaMaxima,$productos,$categoria);
                    if($totalVentas<=1){
                        $total = 1;
                    }else{
                        $total = $totalVentas/8;
                        $total = ceil($total);
                    }
                    $datasDos = Redundancia::paginacionController('ventas',8,$total);
                    $datas = $this->model->ventas($fechaInicio, $fechaMaxima, $productos, $categoria,$datasDos["limiteInicial"],8);
                    $data = Caratula::caratula("Gestor de ventas", false, true, true, "Admin", $datas);
                    $dataDos = Caratula::caratulaFiltrar($data, $categorias, $productos, $categoria, $fechaInicio, $fechaMaxima,$totalVentas);
                    $this->view("ventas", $dataDos);
                }else{
                    $datas = $this->model->ventas("", "", 0, 0,$datasDos["limiteInicial"],8);
                    $data = Caratula::caratula("Gestor de ventas", false, true, true, "Admin", $datas, $errores);
                    $dataDos = Caratula::caratulaFiltrar($data, $categorias, 0, 0, "", "",$totalVentas);
                    $this->view("ventas", $dataDos);
                }
            }else{
                $datas = $this->model->ventas("", "", 0, 0,$datasDos["limiteInicial"],8);
                $data = Caratula::caratula("Gestor de ventas", false, true, true, "Admin", $datas);
                $dataDos = Caratula::caratulaFiltrar($data, $categorias, 0, 0, "", "",$totalVentas);
                $this->view("ventas", $dataDos);
            }
        }else{
            header("Location:".RUTA."loginAdmin");
        }
    }

    function detalle($fecha, $idUsuario){
        $sesion = new Sesion();
        if($sesion->getLogin()){
            $datas = $this->model->detalle($fecha, $idUsuario);
            $data = Caratula::caratula("Detalle Ventas por dia", false, true, true, "Admin", $datas);
            $this->view("detalle", $data);
        }else{
            header("Location:".RUTA."loginAdmin");
        }
    }

    function detalleProductos($idProducto, $fechaInicio="", $fechaMaxima=""){
        $sesion = new Sesion();
        if($sesion->getLogin()){
            $datas = $this->model->detalleProductos($idProducto, $fechaInicio, $fechaMaxima);
            $data = Caratula::caratula("Detalle Ventas por producto", false, true, true, "Admin", $datas);
            $this->view("detalle", $data);
        }else{
            header("Location:".RUTA."loginAdmin");
        }
    }

    function detalleCategorias($categoria, $fechaInicio="", $fechaMaxima=""){
        $sesion = new Sesion();
        if($sesion->getLogin()){
            $datas = $this->model->detalleCategorias($categoria, $fechaInicio, $fechaMaxima);
            $data = Caratula::caratula("Detalle Ventas por producto", false, true, true, "Admin", $datas);
            $this->view("detalle", $data);
        }else{
            header("Location:".RUTA."loginAdmin");
        }
    }

    function grafica(){
        $sesion = new Sesion();
        $total = 0;
        $categorias = $this->model->getLlaves("categoria");
        if($sesion->getLogin()){
            if($_SERVER['REQUEST_METHOD'] == "GET"){
                $errores = array();
                $datasDos = Redundancia::validacionFiltros();
                $errores = $datasDos['errores'];
                $fechaInicio = $datasDos["datas"]['fechaInicio'];
                $fechaMaxima = $datasDos["datas"]['fechaMaxima'];
                $productos = $datasDos["datas"]['productos'];
                $categoria = $datasDos["datas"]['categoria'];
                $totalVentasGrafica = $this->model->totalVentasGrafica($fechaInicio,$fechaMaxima,$productos,$categoria);
                if($totalVentasGrafica<=1){
                    $total = 1;
                }else{
                    $total = $totalVentasGrafica/8;
                    $total = ceil($total);
                }
                $datasDos = Redundancia::paginacionController('grafica',8,$total);
                if(empty($errores)){
                    $datas = $this->model->ventasGrafica($fechaInicio, $fechaMaxima, $productos, $categoria,$datasDos["limiteInicial"],8);
                    $data = Caratula::caratula("Gestor de ventas", false, true, true, "Admin", $datas);
                    $dataDos = Caratula::caratulaFiltrar($data, $categorias, $productos, $categoria, $fechaInicio, $fechaMaxima,$totalVentasGrafica);
                    $this->view("graficaVentas", $dataDos);
                }else{
                    $datas = $this->model->ventasGrafica("", "", 0, 0,$datasDos["limiteInicial"],8);
                    $data = Caratula::caratula("Gestor de ventas", false, true, true, "Admin", $datas, $errores);
                    $dataDos = Caratula::caratulaFiltrar($data, $categorias, 0, 0, $fechaInicio, $fechaMaxima,$totalVentasGrafica);
                    $this->view("graficaVentas", $dataDos);
                }
            }else{
                $datas = $this->model->ventasGrafica("", "", 0, 0,$datasDos["limiteInicial"],8);
                $data = Caratula::caratula("Gestor de ventas", false, true, true, "Admin", $datas);
                $dataDos = Caratula::caratulaFiltrar($data, $categorias, 0, 0, $fechaInicio, $fechaMaxima,$totalVentasGrafica);
                $this->view("graficaVentas", $dataDos);
            }
        }else{
            header("Location:".RUTA."loginAdmin");
        }
    }

    function insertarTemporal(){
        $errores = array();
        $datas = array();
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $dataDos = Redundancia::validacionDatosCliente();
            $datas = $dataDos["datas"];
            $errores = $dataDos["errores"];
        }
        if(empty($errores)){
            $this->model->insertarTemporal($datas);
            $data = Caratula::caratula("Forma de pago", true, false, false, "Tienda Virtual", $datas);
            $this->view("formaPago", $data);
        }else{
            $data = Caratula::caratula("Datos de envio", true, false, false, "Tienda Virtual", $datas, $errores);
            $this->view("datosEnvio", $data);
        }
    }
}
?>