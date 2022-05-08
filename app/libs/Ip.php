<?php

class Ip{
    function __construct() {}

    public function getIp(){    
        if(isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        }else if(isset($_SERVER["HTTP_CLIENT_IP"])) {
            return $_SERVER["HTTP_CLIENT_IP"];
        }else{
            // Usa getenv para obtenerlo si no está permitido  
            if(getenv("HTTP_X_FORWARDED_FOR")){
                return getenv( "HTTP_X_FORWARDED_FOR");
            }else if(getenv("HTTP_CLIENT_IP")) {
                return getenv("HTTP_CLIENT_IP");
            }else{
                return getenv("REMOTE_ADDR");
            }
        }  
        return $_SERVER['REMOTE_ADDR'];
    }

    public function getClase(){
        $ip = $this->getIp();
        $datas = explode(".",$ip);
        $octeto = $datas[0];

        if($octeto>=127){
            return "Clase A";
        }else if($octeto>127&&$octeto<=191){
            return "Clase B";
        }else if($octeto>191&&$octeto<=223){
            return "Clase C";
        }else if($octeto>223&&$octeto<=239){
            return "Clase D";
        }else if($octeto>239&&$octeto<=255){
            return "Clase E";
        }else{
            return "esta en el servidor local, o algo salio mal";
        }
    }

    public function getRedHost(){
        $ip = $this->getip();
        $datas = explode(".",$ip);
        $clase = $this->getClase();
        $octetos = [
            "octeto1" => $datas[0],
            "octeto2" => $datas[1],
            "octeto3" => $datas[2],
            "octeto4" => $datas[3]
        ];

        if($clase=="Clase A"){
            $red = $datas[0].".0";
            $host = $datas[1].".".$datas[2].".".$datas[3];
            $redAndHost = [
                "red" => $red,
                "host" => $host
            ];
            return $redAndHost;
        }else if($clase=="Clase B"){
            $red = $datas[0].".".$datas[1].".0";
            $host = $datas[2].".".$datas[3];
            $redAndHost = [
                "red" => $red,
                "host" => $host
            ];
            return $redAndHost;
        }else if($clase=="Clase C"){
            $red = $datas[0].".".$datas[1].".".$datas[2].".0";
            $host = $datas[3];
            $redAndHost = [
                "red" => $red,
                "host" => $host
            ];
            return $redAndHost;
        }else{
            return "esta en el servidor local, o algo salio mal";
        }
    }

    public function getMascara(){
       $clase = $this->getClase();
       
       if($clase=="Clase A"){
           return "255.0.0.0";
       }else if($clase=="Clase B"){
           return "255.255.0.0";
       }else if($clase=="Clase C"){
           return "255.255.255.0";
       }else{
           return "estamos en local";
       }
    }

    public function getIpNumerica() {
        $ip = $this->getIp();
        $datas = explode(".",$ip);
        if($ip=="::1"){
            return 1;
        }
        $ipNumerica = $datas[0].$datas[1].$datas[2].$datas[3];
        if($ipNumerica>9999999999){
            $ip = substr($ip,0,-1);
            $datas = explode(".",$ip);
            $ipNumerica = $datas[0].$datas[1].$datas[2].$datas[3];
        }
        return $ipNumerica;
    }

    public function insertarTablaTemporal(){
        $db = new MySQLdb();
        $ipNumerica = $this->getIpNumerica();
        $sql = "INSERT INTO tabla_temporal VALUES(0,$ipNumerica)";
        if($this->verificarIp()){
            $datas = $db->queryNoSelect($sql);
            $db->cerrar();
            return $datas;
        }else{
            return "algo salio mal";
        }
    }

    public function verificarIp(){
        $db = new MySQLdb();
        $ipNumerica = $this->getIpNumerica();
        $sql = "SELECT numero FROM tabla_temporal where numero =".$ipNumerica;
        if(!empty($db->query($sql))){
            $db->cerrar();
            return false;
        }else{
            return true;
        }
        $db->cerrar();
        return true;
    }
}
?>