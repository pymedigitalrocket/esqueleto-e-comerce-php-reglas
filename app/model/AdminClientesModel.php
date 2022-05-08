<?php

class AdminClientesModel extends Base{
    private $db;

    function __construct(){
        $this->db = new MySQLdb();
    }

    function insertarCliente($datas){
        $clave = hash_hmac("sha512", $datas["clave1"], "mimamamemima");
        $fechaVacia = "0000-00-00 00:00:00";
        $sql = "INSERT INTO usuario VALUES(0,";
        $sql.= Redundancia::queryCarroTemporal($datas);
        $sql.= "'".$clave."', ";
        $sql.= "1, ";
        $sql.= "0, ";
        $sql.= "(NOW()), ";
        $sql.= "'".$fechaVacia."', ";
        $sql.= "'".$fechaVacia."')";
        return $this->db->queryNoSelect($sql);;
    }

    public function getClientes($limiteInicial,$limiteFinal){
        $sql = "SELECT * FROM usuario WHERE baja=0 limit ".$limiteInicial.",".$limiteFinal;
        return $this->db->querySelect($sql);
    }
    
    public function getClientesNoLimit(){
        $sql = "SELECT * FROM usuario WHERE baja=0";
        return $this->db->querySelect($sql);
    }
    
    public function totalClientes(){
        $sql = "SELECT count(*) as total FROM usuario WHERE baja=0 AND status=1";
        $datas = $this->db->query($sql);
        return $datas["total"];
    }
    
    public function getClienteID($id){
        $sql = "SELECT * FROM usuario WHERE id=".$id; 
        return $this->db->query($sql);
    }

    public function getLlaves($tipo){
        $sql = "SELECT * FROM llave WHERE tipo='".$tipo. "' ORDER BY indice ASC"; 
        return $this->db->querySelect($sql);
    }

    public function editarCliente($datas){
        $errores = array();
        $fecha = $this->getFecha($datas["id"]);
        $fechaVacia = "0000-00-00 00:00:00";
        $sql = "UPDATE usuario SET ";
        $sql.= "nombre='".$datas["nombre"]."', ";
        $sql.= "apellidoPaterno='".$datas["apellidoPaterno"]."', ";
        $sql.= "apellidoMaterno='".$datas["apellidoMaterno"]."', ";
        $sql.= "email='".$datas["email"]."', ";
        $sql.= "direccion='".$datas["direccion"]."', ";
        $sql.= "telefono='".$datas["telefono"]."', ";
        if(!empty($datas['clave1'])&&!empty($datas['clave2'])){
            $clave = hash_hmac('sha256', $datas["clave1"], "mimamamemima");
            $sql.= "clave='".$clave."', ";
        }
        $sql.= "status=".$datas["status"].", ";
        $sql.= "baja=0, ";
        $sql.= "fecha_creacion='".$fecha."', ";
        $sql.= "fecha_modificacion=(NOW()), ";
        $sql.= "fecha_eliminacion='".$fechaVacia."' ";
        $sql.= "WHERE id=".$datas["id"];
        if(!$this->db->queryNoSelect($sql)){
            array_push($errores, "algo salio mal");
        }
        return $errores;
    }

    public function getFecha($id){
        $sql = "SELECT fecha_creacion FROM usuario WHERE id=".$id;
        $datas = $this->db->query($sql);
        $fecha = $datas["fecha_creacion"];
        return $fecha;
    }

    public function borrarLogico($id){
        $errores = array();
        $sql = "UPDATE usuario SET baja=1, status=2, fecha_eliminacion=(NOW()) WHERE id=".$id;
        if(!$this->db->queryNoSelect($sql)){
            array_push($errores, "algo salio mal");
        }
        return $errores;
    }

    public function verificarEmail($datas){
        $errores = array();
        $sql = "SELECT * FROM usuario WHERE email='".$datas["email"]."'";
        $datas = $this->db->query($sql);
        if(!empty($datas)){
            array_push($errores,"el e-mail ya existe en el sistema");
        }
        return $errores;
    }
}
?>