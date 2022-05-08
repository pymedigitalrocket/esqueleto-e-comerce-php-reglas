<?php

class Admin extends Base{
    private $model;

    function __construct(){
        $this->model = $this->model("AdminModel");
    }

    public function caratula(){
        $data = Caratula::caratula("Login Administrativo", false, true, false, "Admin");
        $this->view("loginAdmin", $data);
    }

    public function verifica(){
        $errores = array();
        $datas = array();
        if($_SERVER['REQUEST_METHOD'] =="POST"){
            $email = isset($_POST["email"]) ? $_POST["email"] :"";
            $clave = isset($_POST["clave"]) ? $_POST["clave"] :"";
            if(empty($email)){
                array_push($errores,"el email es requerido");
            }
            if(empty($clave)){
                array_push($errores,"la clave de acceso es requerida");
            }
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                array_push($errores, "El correo electronico no es valido");
            }
            $datas = [
                "email" => $email,
                "clave" => $clave,
                "tipoUsuario" => "admon"
            ];
            if(empty($errores)){
                $errores = $this->model->verificaClave($datas);
                if(empty($errores)){
                    $datas = $this->model->getCorreo($email);
                    $sesion = new Sesion(); 
                    $sesion->iniciar($datas);
                    $data = Caratula::caratula("Perfil Administrativo", false, true, true, "Admin", $datas);
                    $this->view("inicioAdmin", $data);
                }else{
                    $data = Caratula::caratula("Perfil Administrativo", false, true, false, "Admin", $datas, $errores);
                    $this->view("loginAdmin", $data);
                }
            }else{
                $data = Caratula::caratula("Perfil Administrativo", false, true, false, "Admin", $datas, $errores);
                $this->view("loginAdmin", $data);
            }
        }else{
            $this->caratula();
        }
    }
    
    function logout() {
        session_start();
        if(isset($_SESSION["usuario"])){
            $sesion = new Sesion();
            $sesion->finalizarSesion();
        }
        header("Location:".RUTA."admin");
    }
}
?>