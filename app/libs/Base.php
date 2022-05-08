<?php

class Base{
    function __construct(){}

    public function model($model){
        require_once("../app/model/".$model.".php");
        return new $model();
    }

    public function view($view, $data=[]){
        if(file_exists("../app/view/".$view.".php")){
            require_once("../app/view/".$view.".php");
        }else{
            die("La vista no existe...");
        }
    }
}
?>