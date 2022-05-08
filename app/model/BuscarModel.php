<?php

class BuscarModel{
    private $db;

    function __construct(){
        $this->db = new MySQLdb();
    }

    function getProductosBuscar($buscar, $limiteInicial=0, $limiteFinal=0){
        $param = "";
        $sql = "SELECT * FROM producto WHERE ";
        $sql.= "(nombre LIKE '%".$buscar."%' OR ";
        $sql.= "descripcion LIKE '%".$buscar."%' OR ";
        $sql.= "precio LIKE '%".$buscar."%' OR ";
        $sql.= "material LIKE '%".$buscar."%' OR ";
        if($buscar=="vestidos"||$buscar=="vestido"){
            $param = "categoria=1 OR ";
        }else if($buscar=="poleras"||$buscar=="polera"){
            $param = "categoria=2 OR ";
        }else if($buscar=="chaquetas"||$buscar=="chaqueta"){
            $param = "categoria=3 OR ";
        }else if($buscar=="descuento"){
            $param = "descuento>0 OR ";
        }
        $sql2 = "marca LIKE '%".$buscar."%') limit ".$limiteInicial.",".$limiteFinal;
        $sqlFinal = $sql." ".$param." ".$sql2;
        return $this->db->querySelect($sqlFinal);
    }
    
    function totalBuscar($buscar){
        $sql = Redundancia::paginacionModelBuscar($buscar);
        $datas = $this->db->query($sql);
        return $datas["total"];
    }
}
?>