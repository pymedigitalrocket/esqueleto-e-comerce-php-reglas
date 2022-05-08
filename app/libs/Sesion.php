<?php

class Sesion{

    function __construct(){
        session_start();
        if(isset($_SESSION["usuario"])){
            $this->usuario = $_SESSION["usuario"];
            $this->login = true;
            if(isset($_SESSION["usuario"]["id"])){
                $idUsuario = $_SESSION["usuario"]["id"];
                if(isset($_SESSION["usuario"]["tipo_usuario_admon"])){
                    $_SESSION["rol"] = $_SESSION["usuario"]["tipo_usuario_admon"];
                }
                if($this->cantidadProducto($idUsuario)!=null){
                    $_SESSION["carro"] = $this->cantidadProducto($idUsuario);
                }else{
                    $_SESSION["carro"] = 0;
                }
            }
        }else{
            $ip = new Ip();
            $ip->insertarTablaTemporal();
            $_SESSION["temporal"] = $ip->getIpNumerica();
            $idTemporal = $_SESSION["temporal"];
            if($this->cantidadProducto($idTemporal)!=null){
                $_SESSION["carro"] = $this->cantidadProducto($idTemporal);
            }else{
                $_SESSION["carro"] = 0;
            }
        }
    }

    public function iniciar($usuario){
        if($usuario){
            $this->usuario = $_SESSION["usuario"] = $usuario;
            $this->login = true;
        }else{
            $this->login = false;
        }        
    }

    public function finalizarSesion(){
        unset($_SESSION["usuario"]);
        unset($this->usuario);
        session_destroy();
        $this->login = false;
    }

    public function getLogin(){
        return $this->login;
    }

    public function getUsuario(){
        return $this->usuario;
    }

    public function cantidadProducto($idUsuario){
        $db = new MySQLdb();
        $cantidad = 0;
        $sql = "SELECT SUM(c.cantidad) as cantidad FROM carro as c, producto as p WHERE c.id_usuario=".$idUsuario." AND c.id_producto=p.id AND c.estado=0";
        $datas = $db->query($sql);
        if($datas!=null){
            $cantidad = $datas["cantidad"];
        }
        $db->cerrar();
        return $cantidad;
    }

    public function getRol($idUsuario){
        $db = new MySQLdb();
        $sql = "SELECT tipo_usuario_admon FROM admon WHERE id=".$idUsuario;
        $datas = $db->query($sql);
        $db->cerrar();
        return $datas["tipo_usuario_admon"];
    }
}
?>