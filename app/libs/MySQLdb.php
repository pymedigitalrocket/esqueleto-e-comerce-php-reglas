<?php

class MySQLdb{
    private $host = "localhost";
    private $usuario = "root";
    private $clave = "";
    private $db = "ecomerce_reglas";
    private $puerto = "";
    private $conn;


    function __construct(){
        $this->conn = mysqli_connect($this->host, $this->usuario, $this->clave, $this->db);
        if(mysqli_connect_errno()){
            printf("Error en la conexion a base de datos %s", mysqli_connect_errno());
            exit();
        }else{
            //print "Conexion exitosa"."<br>";
        }

        if(!mysqli_set_charset($this->conn, 'utf8')){
            printf("Error en la conversion de caracteres %s", mysqli_connect_err());
            exit();
        }else{
            //print "El conjunto de caracteres es: ".mysqli_character_set_name($this->conn)."<br>";
        }
    }

    function query($sql){
        $datas = array();
        $r = mysqli_query($this->conn, $sql);
        if($r){
            if(mysqli_num_rows($r)>0){
                $datas = mysqli_fetch_assoc($r);
            }
        }
        return $datas;
    }

    function queryNoSelect($sql){ 
        return mysqli_query($this->conn, $sql);
    }

    function querySelect($sql){
        $datas = array();
        $r = mysqli_query($this->conn, $sql);
        if($r){
            while($row = mysqli_fetch_assoc($r)){
                array_push($datas, $row);
            }
        }
        return $datas;
    }

    function cerrar(){
        mysqli_close($this->conn);
    }
}
?>