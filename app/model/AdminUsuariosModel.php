<?php

class adminUsuariosModel{
    private $db;

    function __construct(){
        $this->db = new MySQLdb();
    }

    function insertarUsuarioAdmin($datas){
        $rolAdmin = $_SESSION["rol"];
        $clave = hash_hmac('sha256', $datas["clave1"], "mimamamemima");
        $fechaVacia = "0000-00-00 00:00:00";
        $rol = $datas["tipoUsuarioAdmon"];
        $sql = "INSERT INTO admon VALUES (0, ";
        $sql.= "'".$datas['nombre']."', ";
        $sql.= "'".$datas['correo']."', ";
        $sql.= "'".$clave."', ";
        if($rolAdmin==1){
            if($rol!=1){
                $sql.=$rol.", ";
            }else{
                return false;
            }
        }else if($rol==2){
            if($rol!=1&&$rol!=2){
                $sql.=$rol.", ";
            }else{
                return false;
            }
        }
        $sql.= "1, ";
        $sql.= "0, ";
        $sql.= "'".$fechaVacia."', ";
        $sql.= "(NOW()), ";
        $sql.= "'".$fechaVacia."', ";
        $sql.= "'".$fechaVacia."') ";
        return $this->db->queryNoSelect($sql);
    }

    public function getUsers($limiteInicial,$limiteFinal){
        $sql = "SELECT * FROM admon WHERE baja=0 limit ".$limiteInicial.",".$limiteFinal;
        return $this->db->querySelect($sql);
    }
    
    public function getUsersNoLimit(){
        $sql = "SELECT * FROM admon WHERE baja=0";
        return $this->db->querySelect($sql);
    }
    
    public function totalUsuarios(){
        $sql = "SELECT count(*) as total FROM admon WHERE baja=0 AND status=1";
        $datas = $this->db->query($sql);
        return $datas["total"];
    }

    public function getUsersID($id){
        $sql = "SELECT * FROM admon WHERE id=".$id; 
        return $this->db->query($sql);
    }

    public function getLlaves($tipo){
        $sql = "SELECT * FROM llave WHERE tipo='".$tipo. "' ORDER BY indice ASC"; 
        return $this->db->querySelect($sql);
    }

    public function editarUsuario($datas){
        $errores = array();
        $rol = $datas["tipoUsuarioAdmon"];
        $sesionRol = $_SESSION["rol"];
        $sql = "UPDATE admon SET ";
        $sql.= "nombre='".$datas["nombre"]."', ";
        $sql.= "correo='".$datas["correo"]."', ";
        if(!empty($datas['clave1'])&&!empty($datas['clave2'])){
            $clave = hash_hmac('sha256', $datas["clave1"], "mimamamemima");
            $sql.= "clave='".$clave."', ";
        }
        if($sesionRol==1){
            if($rol!=1){
                $sql.= "tipo_usuario_admon=".$rol.", ";
            }else{
                array_push($errores, "ud no puede dar el rol de Root");
            }
        }else if($sesionRol==2){
            if($rol!=1&&$rol!=2){
                $sql.= "tipo_usuario_admon=".$rol.", ";
            }else{
                array_push($errores, "ud no puede dar el rol de root, ni dueño");
            }
        }else{
            array_push($errores, "acceso restringido"); 
        }
        $sql.= "status=".$datas["status"].", ";
        $sql.= "fecha_modificacion=(NOW()) ";
        $sql.= " WHERE id=".$datas["id"];
        if(!$this->db->queryNoSelect($sql)){
            array_push($errores, "algo salio mal");
        }
        return $errores;
    }

    public function borrarLogico($id){
        $errores = array();
        $sql = "UPDATE admon SET baja=1, status=2, fecha_eliminacion=(NOW()) WHERE id=".$id;
        if(!$this->db->queryNoSelect($sql)){
            array_push($errores, "algo salio mal");
        }
        return $errores;
    }

    public function verificarEmail($datas){
        $errores = array();
        $sql = "SELECT * FROM admon WHERE correo='".$datas["correo"]."'";
        $datas = $this->db->query($sql);
        if(!empty($datas)){
            array_push($errores,"el e-mail ya existe en el sistema");
        }
        return $errores;
    }
}
?>