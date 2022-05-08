<?php

class Caratula{
    function __construct() {}

    static function caratula($titulo="", $menu=false, $admin=false, $adminMenu=false, $tituloMenu="", $datas=[], $errores=[]){
        $data = [
            "titulo" => $titulo,
            "menu" => $menu,
            "admin" => $admin,
            "adminMenu" => $adminMenu,
            "tituloMenu" => $tituloMenu,
            "datas" => $datas,
            "errores" => $errores,
        ];
        return $data;
    }

    static function caratulaError($data=[], $subtitulo="", $texto="", $color="", $url="", $colorBtn="", $textoBtn=""){
        $data = [
            "titulo" => $data["titulo"],
            "menu" => $data["menu"],
            "admin" => $data["admin"],
            "adminMenu" => $data["adminMenu"],
            "tituloMenu" => $data["tituloMenu"],
            "subtitulo" => $subtitulo,
            "texto" => $texto,
            "color" => $color,
            "url" => $url,
            "colorBtn" => $colorBtn,
            "textoBtn" => $textoBtn
        ];
        return $data;
    }
    
    static function caratulaBuscar($data=[],$total=0, $buscar=""){
        $data = [
            "titulo" => $data["titulo"],
            "menu" => $data["menu"],
            "admin" => $data["admin"],
            "adminMenu" => $data["adminMenu"],
            "tituloMenu" => $data["tituloMenu"],
            "datas" => $data["datas"],
            "errores" => $data["errores"],
            "total" => $total,
            "buscar" => $buscar
        ];
        return $data;
    }

    static function caratulaCatalogo($data=[], $catalogo=[]){
        $data = [
            "titulo" => $data["titulo"],
            "menu" => $data["menu"],
            "admin" => $data["admin"],
            "adminMenu" => $data["adminMenu"],
            "tituloMenu" => $data["tituloMenu"],
            "datas" => $data["datas"],
            "errores" => $data["errores"],
            "catalogo" => $catalogo
        ];
        return $data;
    }
    
    static function caratulaPaginacion($data=[], $catalogo=[],$descuento=[], $total=0, $totalMasVendido=0,$totalDescuento=0){
        $data = [
            "titulo" => $data["titulo"],
            "menu" => $data["menu"],
            "admin" => $data["admin"],
            "adminMenu" => $data["adminMenu"],
            "tituloMenu" => $data["tituloMenu"],
            "datas" => $data["datas"],
            "errores" => $data["errores"],
            "catalogo" => $catalogo,
            "descuento" => $descuento,
            "total" => $total,
            "totalMasVendido" => $totalMasVendido,
            "totalDescuento" => $totalDescuento
        ];
        return $data;
    }
    
    static function caratulaCatalogoPaginacion($data=[], $catalogo=[], $total=0){
        $data = [
            "titulo" => $data["titulo"],
            "menu" => $data["menu"],
            "admin" => $data["admin"],
            "adminMenu" => $data["adminMenu"],
            "tituloMenu" => $data["tituloMenu"],
            "datas" => $data["datas"],
            "errores" => $data["errores"],
            "catalogo" => $catalogo,
            "total" => $total
        ];
        return $data;
    }
    
    static function caratulaPagina($data=[],$total=0){
        $data = [
            "titulo" => $data["titulo"],
            "menu" => $data["menu"],
            "admin" => $data["admin"],
            "adminMenu" => $data["adminMenu"],
            "tituloMenu" => $data["tituloMenu"],
            "datas" => $data["datas"],
            "errores" => $data["errores"],
            "total" => $total
        ];
        return $data;
    }

    static function caratulaFiltrar($data=[], $catalogo=[], $productos=0, $categoria=0, $fechaInicio="", $fechaMaxima="",$total=0){
        $data = [
            "titulo" => $data["titulo"],
            "menu" => $data["menu"],
            "admin" => $data["admin"],
            "adminMenu" => $data["adminMenu"],
            "tituloMenu" => $data["tituloMenu"],
            "datas" => $data["datas"],
            "errores" => $data["errores"],
            "catalogo" => $catalogo,
            "productos" => $productos,
            "categoria" => $categoria,
            "fechaInicio" => $fechaInicio,
            "fechaMaxima" => $fechaMaxima,
            "total" => $total
        ];
        return $data;
    }

    static function caratulaLlaves($data=[], $llaves=[], $subtitulo=""){
        $data = [
            "titulo" => $data["titulo"],
            "menu" => $data["menu"],
            "admin" => $data["admin"],
            "adminMenu" => $data["adminMenu"],
            "tituloMenu" => $data["tituloMenu"],
            "datas" => $data["datas"],
            "errores" => $data["errores"],
            "status" => $llaves,
            "subtitulo" => $subtitulo
        ];
        return $data;
    }

    static function caratulaId($data=[], $idUsuario=""){
        $data = [
            "titulo" => $data["titulo"],
            "menu" => $data["menu"],
            "admin" => $data["admin"],
            "adminMenu" => $data["adminMenu"],
            "tituloMenu" => $data["tituloMenu"],
            "datas" => $data["datas"],
            "errores" => $data["errores"],
            "idUsuario" => $idUsuario
        ];
        return $data;
    }

    
    static function caratulaCarro($data=[], $pago="", $carro=[]){
        $data = [
            "titulo" => $data["titulo"],
            "menu" => $data["menu"],
            "admin" => $data["admin"],
            "adminMenu" => $data["adminMenu"],
            "tituloMenu" => $data["tituloMenu"],
            "datas" => $data["datas"],
            "errores" => $data["errores"],
            "pago" => $pago,
            "carro" => $carro
        ];
        return $data;
    }

    static function caratulaActivo($data=[], $activo="", $subtitulo=""){
        $data = [
            "titulo" => $data["titulo"],
            "menu" => $data["menu"],
            "admin" => $data["admin"],
            "adminMenu" => $data["adminMenu"],
            "tituloMenu" => $data["tituloMenu"],
            "datas" => $data["datas"],
            "errores" => $data["errores"],
            "activo" => $activo,
            "subtitulo" => $subtitulo
        ];
        return $data;
    }

    static function caratulaSubtitulo($data=[], $subtitulo=""){
        $data = [
            "titulo" => $data["titulo"],
            "menu" => $data["menu"],
            "admin" => $data["admin"],
            "adminMenu" => $data["adminMenu"],
            "tituloMenu" => $data["tituloMenu"],
            "datas" => $data["datas"],
            "errores" => $data["errores"],
            "subtitulo" => $subtitulo,
        ];
        return $data;
    }
    
    static function caratulaCategoria($data=[], $subtitulo="", $total=0, $categoria=""){
        $data = [
            "titulo" => $data["titulo"],
            "menu" => $data["menu"],
            "admin" => $data["admin"],
            "adminMenu" => $data["adminMenu"],
            "tituloMenu" => $data["tituloMenu"],
            "datas" => $data["datas"],
            "errores" => $data["errores"],
            "subtitulo" => $subtitulo,
            "total" => $total,
            "tipo" => $categoria
        ];
        return $data;
    }

    static function caratulaConTodo($data=[], $status=[], $catalogo=[], $subtitulo=""){
        $data = [
            "titulo" => $data["titulo"],
            "menu" => $data["menu"],
            "admin" => $data["admin"],
            "adminMenu" => $data["adminMenu"],
            "tituloMenu" => $data["tituloMenu"],
            "datas" => $data["datas"],
            "errores" => $data["errores"],
            "status" => $status,
            "catalogo" => $catalogo,
            "subtitulo" => $subtitulo
        ];
        return $data;
    }

    static function caratulaConTodoMas($data=[], $status=[], $catalogo=[], $subtitulo="", $baja=false){
        $data = [
            "titulo" => $data["titulo"],
            "menu" => $data["menu"],
            "admin" => $data["admin"],
            "adminMenu" => $data["adminMenu"],
            "tituloMenu" => $data["tituloMenu"],
            "datas" => $data["datas"],
            "errores" => $data["errores"],
            "status" => $status,
            "catalogo" => $catalogo,
            "subtitulo" => $subtitulo,
            "baja" => $baja
        ];
        return $data;
    }

    static function caratulaIdMas($data=[], $idUsuario="", $subtitulo="", $regresa="", $talla=[], $categoria=[], $catalogo=[]){
        $data = [
            "titulo" => $data["titulo"],
            "menu" => $data["menu"],
            "admin" => $data["admin"],
            "adminMenu" => $data["adminMenu"],
            "tituloMenu" => $data["tituloMenu"],
            "datas" => $data["datas"],
            "errores" => $data["errores"],
            "idUsuario" => $idUsuario,
            "subtitulo" => $subtitulo,
            "regresa" => $regresa,
            "tallas" => $talla,
            "categoria" => $categoria,
            "catalogo" => $catalogo
        ];
        return $data;
    }

    static function caratulaStatus($data=[], $status=[], $baja=false, $subtitulo=""){
        $data = [
            "titulo" => $data["titulo"],
            "menu" => $data["menu"],
            "admin" => $data["admin"],
            "adminMenu" => $data["adminMenu"],
            "tituloMenu" => $data["tituloMenu"],
            "datas" => $data["datas"],
            "errores" => $data["errores"],
            "status" => $status,
            "baja" => $baja,
            "subtitulo" => $subtitulo
        ];
        return $data;
    }

    static function caratulaProducto($data=[], $status=[], $catalogo=[], $talla=[], $categoria=[], $subtitulo=""){
        $data = [
            "titulo" => $data["titulo"],
            "menu" => $data["menu"],
            "admin" => $data["admin"],
            "adminMenu" => $data["adminMenu"],
            "tituloMenu" => $data["tituloMenu"],
            "datas" => $data["datas"],
            "errores" => $data["errores"],
            "status" => $status,
            "catalogo" => $catalogo,
            "talla" => $talla,
            "categoria" => $categoria,
            "subtitulo" => $subtitulo
        ];
        return $data;
    }

    static function caratulaProductoConTodo($data=[], $status=[], $catalogo=[], $talla=[], $categoria=[], $subtitulo="", $baja = false){
        $data = [
            "titulo" => $data["titulo"],
            "menu" => $data["menu"],
            "admin" => $data["admin"],
            "adminMenu" => $data["adminMenu"],
            "tituloMenu" => $data["tituloMenu"],
            "datas" => $data["datas"],
            "errores" => $data["errores"],
            "status" => $status,
            "catalogo" => $catalogo,
            "talla" => $talla,
            "categoria" => $categoria,
            "subtitulo" => $subtitulo,
            "baja" => $baja
        ];
        return $data;
    }
}
?>