<?php

class TiendaModel{
    private $db;

    function __construct(){
        $this->db = new MySQLdb();
    }

    public function getLlaves($tipo){
        $sql = "SELECT * FROM llave WHERE tipo='".$tipo. "' ORDER BY indice ASC"; 
        return $this->db->querySelect($sql);
    }

    public function getTipoProducto($categoria, $limiteInicial,$limiteFinal){
        if(STOCK){
            $sql = "SELECT * FROM producto WHERE categoria=".$categoria." AND stock>0 AND status>0 AND baja=0 ORDER BY mas_vendido DESC limit ".$limiteInicial.",".$limiteFinal;   
        }else{
            $sql = "SELECT * FROM producto WHERE categoria=".$categoria<" AND baja=0 AND status>0 ORDER BY mas_vendido DESC limit ".$limiteInicial.",".$limiteFinal;
        }
        return $this->db->querySelect($sql);
    }
    
    public function getMasVendidos($limiteInicial,$limiteFinal){
        if(STOCK){
            $sql = "SELECT * FROM producto WHERE mas_vendido>0 AND baja=0 AND stock>0 AND status>0 ORDER BY mas_vendido DESC limit ".$limiteInicial.",".$limiteFinal;    
        }else{
            $sql = "SELECT * FROM producto WHERE mas_vendido>0 AND baja=0 AND status>0 ORDER BY mas_vendido DESC limit ".$limiteInicial.",".$limiteFinal; 
        }
        return $this->db->querySelect($sql);
    }

    public function getNuevos($limiteInicial,$limiteFinal){
        if(STOCK){
            $sql = "SELECT * FROM producto WHERE baja=0 AND stock>0 AND status>0 ORDER BY fecha_creacion DESC limit ".$limiteInicial.",".$limiteFinal;
        }else{
            $sql = "SELECT * FROM producto WHERE baja=0 ORDER BY fecha_creacion AND status>0 DESC limit ".$limiteInicial.",".$limiteFinal;
        }
        return $this->db->querySelect($sql);
    }
    
    public function getDescuento($limiteInicial,$limiteFinal){
        if(STOCK){
            $sql = "SELECT * FROM producto WHERE baja=0 AND stock>0 AND status>0 AND descuento>0 ORDER BY mas_vendido DESC limit ".$limiteInicial.",".$limiteFinal;
        }else{
            $sql = "SELECT * FROM producto WHERE baja=0 AND status>0 AND descuento>0 ORDER BY mas_vendido DESC limit ".$limiteInicial.",".$limiteFinal;
        }
        return $this->db->querySelect($sql);
    }
    
    public function totalProductos(){
        if(STOCK){
            $sql = "SELECT count(*) as total FROM producto WHERE baja=0 AND stock>0";
        }else{
            $sql = "SELECT count(*) as total FROM producto WHERE baja=0";
        }
        $datas = $this->db->query($sql);
        return $datas["total"];
    }
    
    public function totalMasVendido(){
        if(STOCK){
            $sql = "SELECT count(*) as total FROM producto WHERE baja=0 AND mas_vendido>0 AND stock>0";
        }else{
            $sql = "SELECT count(*) as total FROM producto WHERE baja=0 AND mas_vendido>0";
        }
        $datas = $this->db->query($sql);
        return $datas["total"];
    }
    
    public function totalCategoria($categoria){
        if(STOCK){
            $sql = "SELECT count(*) as total FROM producto WHERE categoria=".$categoria." AND baja=0 AND stock>0";
        }else{
            $sql = "SELECT count(*) as total FROM producto WHERE categoria=".$categoria." AND baja=0";
        }
        $datas = $this->db->query($sql);
        return $datas["total"];
    }
    
    public function totalDescuento(){
        if(STOCK){
            $sql = "SELECT count(*) as total FROM producto WHERE baja=0 AND stock>0 AND status>0 AND descuento>0";
        }else{
            $sql = "SELECT count(*) FROM producto WHERE baja=0 AND status>0 AND descuento>0";
        }
        $datas = $this->db->query($sql);
        return $datas["total"];
    }
}
?>