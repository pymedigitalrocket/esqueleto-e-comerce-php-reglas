<?php

class Control{
    protected $controller = "Tienda";
    protected $metodo = "caratula";
    protected $parametros = [];

    function __construct(){
        $url = $this->separarUrl();
        if($url!="" && file_exists("../app/controller/".ucwords($url[0]).".php")){
            $this->controller = ucwords($url[0]);
            unset($url[0]);
        }
        require_once("../app/controller/".ucwords($this->controller).".php");
        $this->controller = new $this->controller;

        if(isset($url[1])){
            if(method_exists($this->controller,$url[1])){
                $this->metodo = $url[1];
                unset($url[1]);
            }
        }
        $this->parametros = $url ? array_values($url) : array();
        call_user_func_array([$this->controller, $this->metodo],$this->parametros);
    }

    function separarUrl(){
        $url = "";
        if(isset($_GET["url"])){
            $url = rtrim($_GET["url"],"/");
            $url = rtrim($_GET["url"],"\\");
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode("/",$url);
        }
        return $url;
    }
}