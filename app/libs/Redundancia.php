<?php

class Redundancia {
    function __construct() {}

    static function validacionDatosCliente(){
        $datas = array();
        $errores = array();

        $nombre = Valida::cadena(isset($_POST["nombre"])?$_POST["nombre"]:"");
        $apellidoPaterno = Valida::cadena(isset($_POST["apellidoPaterno"])?$_POST["apellidoPaterno"]:"");
        $apellidoMaterno = Valida::cadena(isset($_POST["apellidoMaterno"])?$_POST["apellidoMaterno"]:"");
        $email = Valida::cadena(isset($_POST["email"])?$_POST["email"]:"");
        $direccion = Valida::cadena(isset($_POST["direccion"])?$_POST["direccion"]:"");
        $telefono = Valida::cadena(isset($_POST["telefono"])?$_POST["telefono"]:"");

        if($nombre == ""){
            array_push($errores, "El nombre es requerido");
        }
        if($apellidoPaterno == ""){
            array_push($errores, "El apellido paterno es requerido");
        }
        if($email == ""){
            array_push($errores, "El email es requerido");
        }
        if($direccion == ""){
            array_push($errores, "La direccion es requerida");
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            array_push($errores, "El correo electronico no es valido");
        }
        if($telefono == ""){
            array_push($errores, "El telefono es requerido");
        }else if(Valida::validaCodigoCelular($telefono)){
            if(strlen($telefono)==12){
                $numeroCelular = substr($telefono, 3, 9);
                if(!is_numeric($numeroCelular)){
                    array_push($errores, "despues del prefijo +56 debe ingresar su nunmero de celular");
                }
            }else{
                array_push($errores, "Numero de telefono invalido");
            }
        }else{
            if(strlen($telefono)==9){
                if(!is_numeric($telefono)){
                    array_push($errores, "el telefono debe ser un numero");
                }else{
                    $telefono = "+56".$telefono;
                }
            }else{
                array_push($errores, "Numero de telefono invalido");
            }
        }

        $datas = [
            "nombre" => $nombre,
            "apellidoPaterno" => $apellidoPaterno,
            "apellidoMaterno" => $apellidoMaterno,
            "email" => $email,
            "direccion" => $direccion,
            "telefono" => $telefono
        ];

        $data = [
            "datas" => $datas,
            "errores" => $errores
        ];

        return $data;
    }

    static function validacionFiltros(){
        $datas = array();
        $errores = array();

        $fechaInicio = isset($_GET["fechaInicio"])?$_GET["fechaInicio"]:"";
        $fechaMaxima = isset($_GET["fechaMaxima"])?$_GET["fechaMaxima"]:"";
        $productos = isset($_GET["productos"])?$_GET["productos"]:"";
        $productos = ($productos=="")?"0":"1";
        $categoria = isset($_GET["categoria"])?$_GET["categoria"]:"";
        $categoria = ($categoria=="")?"0":"1";
        if(!empty($fechaInicio)){
            if(Valida::fecha($fechaInicio)){
                array_push($errores,"La fecha no es valida (AAAA-MM-DD)");
            }else if(Valida::fechaDia($fechaInicio)){
                array_push($errores,"La fecha de inicio no puede ser mayor a la del dia de hoy");
            }
            if(!empty($fechaMaxima)){
                if(Valida::fecha($fechaInicio)){
                    array_push($errores,"La fecha de inicio no es valida (AAAA-MM-DD)");
                }else if(Valida::fechaDia($fechaInicio)){
                    array_push($errores,"La fecha de inicio no puede ser mayor a la del dia de hoy");
                }
            }
        }
        if(empty($errores)){
            if($fechaInicio>$fechaMaxima){
                array_push($errores,"Las fechas no son validas");
            }
        }
        if($productos==1&&$categoria==1){
            array_push($errores,"no puede filtrar por productos y categorias a la vez");
        }

        $datas = [
            "fechaInicio" =>$fechaInicio,
            "fechaMaxima" =>$fechaMaxima,
            "productos" =>$productos,
            "categoria" =>$categoria
        ];

        $data = [
            "datas" =>$datas,
            "errores" =>$errores
        ];

        return $data;
    }
    
    static function queryCarroTemporal($datas){
        $sql = "'".$datas["nombre"]."', ";
        $sql.= "'".$datas["apellidoPaterno"]."', ";
        $sql.= "'".$datas["apellidoMaterno"]."', ";
        $sql.= "'".$datas["email"]."', ";
        $sql.= "'".$datas["direccion"]."', ";
        $sql.= "'".$datas["telefono"]."', ";
        return $sql;
    }

    static function paginacionController($get,$limiteFinal,$total){
        if(!isset($_GET[$get])){
            $_GET[$get] = 1;
            $limiteInicial = 0;
        }else if($_GET[$get]>$total){
            $_GET[$get] = 1;
            $limiteInicial = 0;
        }else{
            $limiteInicial = ($_GET[$get]-1)*$limiteFinal;            
        }
        $datas = [
            "get" => $_GET[$get],
            "limiteInicial" => $limiteInicial
        ];
        return $datas;
    }

    static function paginacionModelBuscar($buscar){
        $param = "";
        $sql = "SELECT count(*) as total FROM producto WHERE ";
        $sql.= "(nombre LIKE '%".$buscar."%' OR ";
        $sql.= "descripcion LIKE '%".$buscar."%' OR ";
        $sql.= "precio LIKE '%".$buscar."%' OR ";
        $sql.= "material LIKE '%".$buscar."%' OR ";
        if($buscar=="vestidos"){
            $param = "categoria=1 OR ";
        }else if($buscar=="poleras"){
            $param = "categoria=2 OR ";
        }else if($buscar=="chaquetas"){
            $param = "categoria=3 OR ";
        }else if($buscar=="descuento"){
            $param = "descuento>0 OR ";
        }
        $sql2 = "marca LIKE '%".$buscar."%')";
        $sqlFinal = $sql." ".$param." ".$sql2;
        return $sqlFinal;
    }

    static function paginacionModelVentas($fechaInicio, $fechaMaxima, $productos, $categoria,$primerDia,$ultimoDia){
        $sql = "SELECT c.id_producto as producto, p.nombre as nombre_producto, p.categoria as categoria, c.id_usuario, ";
        $sql.= "SUM(p.precio*c.cantidad) as subtotal".", ";
        $sql.= "SUM(p.precio * (c.descuento/100) * c.cantidad) as descuento, ";
        $sql.= "SUM(p.precio*c.cantidad) - SUM(p.precio * (c.descuento/100) * c.cantidad) as total".", ";
        $sql.= "DATE(c.fecha_compra) as fecha ";
        $sql.= "FROM carro as c, producto as p ";
        $sql.= "WHERE c.id_producto=p.id AND ";
        $sql.= "c.estado=1 ";
        if(!empty($fechaInicio)&&!empty($fechaMaxima)){
            if($productos==1){
                $sql.= "AND date(c.fecha_compra) BETWEEN '".$fechaInicio."' AND '".$fechaMaxima."' ";
                $sql.= "GROUP BY p.nombre ";
                $sql.= "ORDER BY SUM(p.precio*c.cantidad) - SUM(p.precio * (c.descuento/100) * c.cantidad) DESC";
            }else if($categoria==1){
                $sql.= "AND date(c.fecha_compra) BETWEEN '".$fechaInicio."' AND '".$fechaMaxima."' ";
                $sql.= "GROUP BY p.categoria ";
                $sql.= "ORDER BY SUM(p.precio*c.cantidad) - SUM(p.precio * (c.descuento/100) * c.cantidad) DESC";
            }else{
                $sql.= "AND date(c.fecha_compra) BETWEEN '".$fechaInicio."' AND '".$fechaMaxima."' ";
                $sql.= "GROUP BY DATE(c.fecha_compra), id_usuario";
            }
        }else if($productos==1){
            $sql.= "AND date(c.fecha_compra) BETWEEN '".$primerDia."' AND '".$ultimoDia."' ";
            $sql.= "GROUP BY p.nombre ";
            $sql.= "ORDER BY SUM(p.precio*c.cantidad) - SUM(p.precio * (c.descuento/100) * c.cantidad) DESC";
        }else if($categoria==1){
            $sql.= "AND date(c.fecha_compra) BETWEEN '".$primerDia."' AND '".$ultimoDia."' ";
            $sql.= "GROUP BY p.categoria ";
            $sql.= "ORDER BY SUM(p.precio*c.cantidad) - SUM(p.precio * (c.descuento/100) * c.cantidad) DESC";
        }else{
            $sql.= "AND date(c.fecha_compra) BETWEEN '".$primerDia."' AND '".$ultimoDia."' ";
            $sql.= "GROUP BY DATE(c.fecha_compra), id_usuario";
        }
        return $sql;
    }

    static function paginacionModelGrafica($fechaInicio, $fechaMaxima, $productos, $categoria,$primerDia,$ultimoDia){
        if($productos==1){
            $sql = "SELECT p.nombre as nombre_producto, ";
            $sql.= "SUM(p.precio*c.cantidad) - SUM(p.precio * (c.descuento/100) * c.cantidad) as total"." ";
        }else if($categoria==1){
            $sql = "SELECT p.categoria as categoria, ";
            $sql.= "SUM(p.precio*c.cantidad) - SUM(p.precio * (c.descuento/100) * c.cantidad) as total"." ";
        }else{
            $sql = "SELECT "."SUM(p.precio*c.cantidad) - SUM(p.precio * (c.descuento/100) * c.cantidad) as total".", ";
            $sql.= "DATE(c.fecha_compra) as fecha ";
        }
        $sql.= "FROM carro as c, producto as p ";
        $sql.= "WHERE c.id_producto=p.id AND c.estado=1 ";
        if(!empty($fechaInicio)&&!empty($fechaMaxima)){
            if($productos==1){
                $sql.= "AND date(c.fecha_compra) BETWEEN '".$fechaInicio."' AND '".$fechaMaxima."' ";
                $sql.= "GROUP BY p.nombre ";
                $sql.= "ORDER BY SUM(p.precio*c.cantidad) - SUM(p.precio * (c.descuento/100) * c.cantidad) DESC";
            }else if($categoria==1){
                $sql.= "AND date(c.fecha_compra) BETWEEN '".$fechaInicio."' AND '".$fechaMaxima."' ";
                $sql.= "GROUP BY p.categoria ";
                $sql.= "ORDER BY SUM(p.precio*c.cantidad) - SUM(p.precio * (c.descuento/100) * c.cantidad) DESC";
            }else{
                $sql.= "AND date(c.fecha_compra) BETWEEN '".$fechaInicio."' AND '".$fechaMaxima."' ";
                $sql.= "GROUP BY DATE(c.fecha_compra), id_usuario";
            }
        }else if($productos==1){
            $sql.= "AND date(c.fecha_compra) BETWEEN '".$primerDia."' AND '".$ultimoDia."' ";
            $sql.= "GROUP BY p.nombre ";
            $sql.= "ORDER BY SUM(p.precio*c.cantidad) - SUM(p.precio * (c.descuento/100) * c.cantidad) DESC";
        }else if($categoria==1){
            $sql.= "AND date(c.fecha_compra) BETWEEN '".$primerDia."' AND '".$ultimoDia."' ";
            $sql.= "GROUP BY p.categoria ";
            $sql.= "ORDER BY SUM(p.precio*c.cantidad) - SUM(p.precio * (c.descuento/100) * c.cantidad) DESC";
        }else{
            $sql.= "AND date(c.fecha_compra) BETWEEN '".$primerDia."' AND '".$ultimoDia."' ";
            $sql.= "GROUP BY DATE(c.fecha_compra), id_usuario";
        }
        return $sql;
    }
}
?>