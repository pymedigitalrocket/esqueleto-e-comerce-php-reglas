<?php

class ProductosModel{
    private $db;

    function __construct(){
        $this->db = new MySQLdb();
    }

    function insertarProducto($datas){
        $fechaVacia = "0000-00-00 00:00:00";
        $sql = "INSERT INTO producto VALUES(0, ";
        $sql.= "'".$datas['nombre']."', ";
        $sql.= "'".$datas['descripcion']."', ";
        $sql.= "'".$datas['marca']."', ";
        $sql.= "'".$datas['talla']."', ";
        $sql.= "'".$datas['material']."', ";
        $sql.= $datas['precio'].", ";
        $sql.= "'".$datas['imagen1']."', ";
        $sql.= "'".$datas['imagen2']."', ";
        $sql.= "'".$datas['imagen3']."', ";
        $sql.= "'".$datas['relacion1']."', ";
        $sql.= "'".$datas['relacion2']."', ";
        $sql.= "'".$datas['relacion3']."', ";
        $sql.= "'".$datas['categoria']."', ";
        $sql.= $datas['descuento'].", ";
        $sql.= $datas['stock'].", ";    
        $sql.= "0, ";
        $sql.= $datas['status'].", ";
        $sql.= "0, ";
        $sql.= "(NOW()), ";
        $sql.= "'".$fechaVacia."', ";
        $sql.= "'".$fechaVacia."')";
        return $this->db->queryNoSelect($sql);
    }

    public function getProductos($limiteInicial,$limiteFinal){
        $sql = "SELECT * FROM producto WHERE baja=0 limit ".$limiteInicial.",".$limiteFinal;
        return $this->db->querySelect($sql);
    }
    
    public function totalProductos(){
        $sql = "SELECT count(*) as total FROM producto WHERE baja=0";
        $datas = $this->db->query($sql);
        return $datas["total"];
    }

    public function getProductosID($id){
        $sql = "SELECT * FROM producto WHERE id=".$id; 
        return $this->db->query($sql);
    }

    public function getCatalogos(){
        if(STOCK){
            $sql = "SELECT * FROM producto WHERE baja=0 AND status!=2 AND stock>0 ORDER BY nombre";
        }else{
            $sql = "SELECT * FROM producto WHERE baja=0 AND status!=2 ORDER BY nombre";
        }
        return $this->db->querySelect($sql);
    }

    public function editarProducto($datas){
        $salida = false;
        $datasDos = $this->masVendido($datas["id"]);
        $masVendido = $datasDos["mas_vendido"];
        if(!empty($datas["id"])){
            $sql = "UPDATE producto SET ";
            $sql.= "nombre='".$datas['nombre']."', ";
            $sql.= "descripcion='".$datas['descripcion']."', ";
            $sql.= "marca='".$datas['marca']."', ";
            $sql.= "talla='".$datas['talla']."', ";
            $sql.= "material='".$datas['material']."', ";
            $sql.= "precio=".$datas['precio'].", ";
            $sql.= "imagen1='".$datas['imagen1']."', ";
            $sql.= "imagen2='".$datas['imagen2']."', ";
            $sql.= "imagen3='".$datas['imagen3']."', ";
            $sql.= "relacion1='".$datas['relacion1']."', ";
            $sql.= "relacion2='".$datas['relacion2']."', ";
            $sql.= "relacion3='".$datas['relacion3']."', ";
            $sql.= "categoria='".$datas['categoria']."', ";
            $sql.= "descuento=".$datas['descuento'].", ";
            $sql.= "stock=".$datas['stock'].", ";
            if($masVendido>0){
                $sql.= "mas_vendido=".$masVendido.", ";
            }else{
                $sql.= "mas_vendido=0, ";
            }
            $sql.= "status=".$datas['status'].", ";
            $sql.= "baja=0, ";
            $sql.= "fecha_modificacion=(NOW()) ";
            $sql.= "WHERE id =".$datas['id'];
            $salida =  $this->db->queryNoSelect($sql);
        }
        return $salida;
    }

    public function borrarLogico($id){
        $sql = "UPDATE producto SET baja=1, status=2, fehca_eliminacion=(NOW()) WHERE id=".$id;
        return $this->db->queryNoSelect($sql);
    }

    public function getMasVendidos(){
        if(STOCK){
            $sql = "SELECT * FROM producto WHERE mas_vendido>0 AND baja=0 AND stock>0 ORDER BY mas_vendido DESC";    
        }else{
            $sql = "SELECT * FROM producto WHERE mas_vendido>0 AND baja=0 ORDER BY mas_vendido DESC"; 
        }
        return $this->db->querySelect($sql);
    }

    public function getNuevos(){
        if(STOCK){
            $sql = "SELECT * FROM producto WHERE baja=0 AND stock>0 ORDER BY fecha_creacion DESC";
        }else{
            $sql = "SELECT * FROM producto WHERE baja=0 ORDER BY fecha_creacion DESC";
        } 
        return $this->db->querySelect($sql);
    }

    public function getLlaves($tipo){
        $sql = "SELECT * FROM llave WHERE tipo='".$tipo. "' ORDER BY indice ASC"; 
        return $this->db->querySelect($sql);
    }

    public function masVendido($idProducto){
        $sql = "SELECT mas_vendido FROM producto WHERE id=".$idProducto;
        return $this->db->query($sql);
    }
}
?>