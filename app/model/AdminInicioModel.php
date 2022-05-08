<?php

class AdminInicioModel{
    private $db;

    function __construct(){
        $this->db = new MySQLdb();
    }
}
?>