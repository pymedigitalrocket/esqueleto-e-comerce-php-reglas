<?php

class Contacto extends base{
    private $model;

    function __construct(){
        $this->model = $this->model("ContactoModel");
    }

    function caratula(){
        $sesion = new Sesion();
        $data = Caratula::caratula("contacto", true, false, false, "Tienda Virtual");
        $dataDos = Caratula::caratulaActivo($data, "contacto");
        $this->view("contacto", $dataDos);
    }

    public function enviar(){
        $errores = array();
        $datas = array();
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $nombre = Valida::cadena(isset($_POST["nombre"])?$_POST["nombre"]:"");
            $email = Valida::cadena(isset($_POST["correo"])?$_POST["correo"]:"");
            $telefono = isset($_POST["telefono"])?$_POST["telefono"]:"";
            $mensaje = Valida::cadena(isset($_POST["mensaje"])?$_POST["mensaje"]:"");
            if($nombre == ""){
                array_push($errores, "El nombre es requerido");
            }
            if($email == ""){
                array_push($errores, "El email es requerido");
            }
            if($mensaje == ""){
                array_push($errores, "El mensaje es requerido");
            }
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                array_push($errores, "El correo electronico no es valido");
            }
            $datas = [
                "nombre" => $nombre,
                "email" => $email,
                "telefono" => $telefono,
                "mensaje" => $mensaje
            ];
            if(empty($errores)){
                if($this->model->enviarCorreo($datas)){
                    $data = Caratula::caratula("Contacto", true, false, false, "Tienda Virtual");
                    $dataDos = Caratula::caratulaError($data, "Contacto", "Se nos ha enviado un correo a nuestra tienda, con su mensaje y datos para ponernos en contacto con ud. Tambien le mandamos una copia a su correo: <b>".$email."</b> con el mismo formato que nos llega a nosotros. Porfavor revisar tu bandeja de spam", "alert-success", "tienda", "btn-primary", "Regresar");
                    $this->view("mensaje", $dataDos);
                }else{
                    $data = Caratula::caratula("Error en el envio del correo", true, false, false, "Tienda Virtual");
                    $dataDos = Caratula::caratulaError($data, "Lo sentimos, algo salio mal", "Error. Existio un problema al enviar el correo", "alert-danger", "tienda", "btn-primary", "Regresar");
                    $this->view("mensaje", $dataDos);
                }
            }else{
                $data = Caratula::caratula("Contacto", true, false, false, "Tienda Virtual", $datas, $errores);
                $dataDos = Caratula::caratulaActivo($data, "contacto");
                $this->view("contacto", $dataDos);
            }
        }
    }
}
?>