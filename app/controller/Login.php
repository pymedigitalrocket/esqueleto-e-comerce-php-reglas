<?php

class Login extends Base{
    private $model;

    function __construct(){
        $this->model = $this->model("LoginModel");
    }

    function caratula(){
        if(isset($__COOKIE["data"])){
            $data_array = explode("|",$__COOKIE["data"]);
            $email = $data_array[0];
            $clave = $data_array[1];
            $datas = [
                "email" => $email,
                "clave" => $clave,
                "recordar" => "on"
            ];
        }else{
            $datas = [];
        }
        $data = Caratula::caratula("Login", false, false, false, "Tienda Virtual", $datas);
        $this->view("login", $data);
    }

    function registro(){
        $errores = array();
        $datas = array();
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $errores = array();
            $datas = array();
            $id = isset($_POST['id'])?$_POST['id']:"";
            $dataDos = Redundancia::validacionDatosCliente();
            $errores = $dataDos["errores"];
            $clave1 = Valida::cadena(isset($_POST["clave1"])?$_POST["clave1"]:"");
            $clave2 = Valida::cadena(isset($_POST["clave2"])?$_POST["clave2"]:"");
            $status = isset($_POST["status"])?$_POST["status"]:"";

            if($clave1 == ""){
                array_push($errores, "La clave es requerida");
            }
            if($clave2 == ""){
                array_push($errores, "Confirme su contraseña");
            }
            if($clave1!=$clave2){
                array_push($errores, "Las claves no coinciden");
            }

            $datas = [
                "id" => $id,
                "nombre" => $dataDos["datas"]["nombre"],
                "apellidoPaterno" => $dataDos["datas"]["apellidoPaterno"],
                "apellidoMaterno" => $dataDos["datas"]["apellidoMaterno"],
                "email" => $dataDos["datas"]["email"],
                "direccion" => $dataDos["datas"]["direccion"],
                "telefono" => $dataDos["datas"]["telefono"],
                "clave1" => $clave1,
                "clave2" => $clave2,
                "status" => $status
            ];

            if(empty($errores)){
                if($this->model->insertar($datas)){
                    $data = caratula::caratula("Bienvenido a la tinda virtual", false, false, false, "Tienda Virtual");
                    $dataDos = Caratula::caratulaError($data, "Bienvenido a nuestra tienda", "Gracias pro su registro", "alert-success", "menu", "btn-primary", "Iniciar");
                    $this->view("mensaje", $dataDos);
                }else{
                    $data = caratula::caratula("Error al registrar el usuario", false, false, false, "Tienda Virtual");
                    $dataDos = Caratula::caratulaError($data, "Lo sentimos, algo salio mal", "Error. Algo salio mal al momento de su registro. Probablemente su correo ya existe en nuestro sistema. Porfavor ingrese otro, a ver si el error desaparece", "alert-danger", "login/registro", "btn-primary", "Regresar");
                    $this->view("mensaje", $dataDos);
                }
            }else{
                $data = Caratula::caratula("Registro de Usuario", false, false, false, "Tienda Virtual", $datas, $errores);
                $this->view("registro", $data);
            }
        }else{
            $data = Caratula::caratula("Registro de Usuario", false, false, false, "Tienda Virtual");
            $this->view("registro", $data);
        }
    }

    function verifica(){
        $errores = array();
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $email = Valida::cadena(isset($_POST["email"])?$_POST["email"]:"");
            $clave = Valida::cadena(isset($_POST["clave"])?$_POST["clave"]:"");
            $recordar = isset($POST["recordar"])?"on":"off";
            $errores = $this->model->verificar($email, $clave);
            $valor = $email."|".$clave;
            if($recordar=="on"){
                $fecha = time()+(60*60*24*7);
            }else{
                $fecha = time() - 1;
            }
            setcookie("data",$valor,$fecha,RUTA);
            $datas = [
                "email" => $email,
                "clave" => $clave,
                "recordar" => $recordar,
                "tipoUsuario" => "cliente"
            ];
            if(empty($errores)){
                $datas = $this->model->getCorreo($email);
                $sesion = new Sesion();
                $sesion->iniciar($datas);
                header("location:".RUTA."tienda");
            }else{
                $data = Caratula::caratula("Login", false, false, false, "Tienda Virtual", $datas, $errores);
                $this->view("login", $data);
            }
        }
    }

    function olvido(){
        $errores = array();
        $datas = array();
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $email = Valida::cadena(isset($_POST["email"])?$_POST["email"]:"");
            $datas = [
                "email" => $email
            ];
            if($email == ""){
                array_push($errores, "El email es requerido");
            }
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                array_push($errores, "El correo electronico no es valido");
            }
            if($this->model->validaCorreo($email)){
                array_push($errores, "El correo electronico no existe en el sistema");
            }
            if(empty($errores)){
                if(!$this->model->enviarCorreo($email)){
                    $data = Caratula::caratula("Cambio de contraseña", false, false, false, "Tienda Virtual");
                    $dataDos = Caratula::caratulaError($data, "Cambio de clave de acceso", "Se ha enviado un correo a <b>".$email."</b> porfavor revisar tu bandeja de spam", "alert-success", "login", "btn-primary", "Regresar");
                    $this->view("mensaje", $dataDos);
                }else{
                    $data = Caratula::caratula("Error en el envio del correo", false, false, false, "Tienda Virtual");
                    $dataDos = Caratula::caratulaError($data, "Lo sentimos, algo salio mal", "Error. Existio un problema al enviar el correo", "alert-danger", "login", "btn-primary", "Regresar");
                    $this->view("mensaje", $dataDos);
                }
            }else{
                $data = Caratula::caratula("Cambio de contraseña", false, false, false, "Tienda Virtual", $datas, $errores);
                $dataDos = Caratula::caratulaSubtitulo($data, "¿olvidaste tu contraseña?");
                $this->view("olvido", $dataDos); 
            }
        }else{
            $data = Caratula::caratula("Cambio de contraseña", false, false, false, "Tienda Virtual");
            $dataDos = Caratula::caratulaSubtitulo($data, "¿olvidaste tu contraseña?");
            $this->view("olvido", $dataDos);
        }
    }

    function cambioClave($datas) {
        $errores = array();
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $id = isset($_POST["id"])?$_POST["id"]:"";
            $clave1 = Valida::cadena(isset($_POST["clave1"])?$_POST["clave1"]:"");
            $clave2 = Valida::cadena(isset($_POST["clave2"])?$_POST["clave2"]:"");
            if($clave1 == ""){
                array_push($errores, "la nueva clave es requerida");
            }
            if($clave2 == ""){
                array_push($errores, "debe validar su contraseña");
            }
            if($clave1!=$clave2){
                array_push($errores, "las claves no coinciden");
            }
            if(count($errores)){
                $data = $data = Caratula::caratula("Cambiar clave de acceso", false, false, false, "Tienda Virtual", $datas, $errores);
                $this->view("cambioClave", $data);
            }else{
                if($this->model->cambiarClave($id, $clave1)){
                    $data = Caratula::caratula("Cambiar clave de acceso", false, false, false, "Tienda Virtual");
                    $dataDos = Caratula::caratulaError($data, "Cambiar Clave de acceso", "Se cambio la contraseña con exito", "alert-success", "login", "btn-primary", "Regresar");
                    $this->view("mensaje", $dataDos);
                }else{
                    $data = Caratula::caratula("Error al cambiar la contraseña", false, false, false, "Tienda Virtual");
                    $dataDos = Caratula::caratulaError($data, "Lo sentimos, algo salio mal", "Error. Existio un problema al modificar la clave de la clave de acceso", "alert-danger", "login", "btn-primary", "Regresar");
                    $this->view("mensaje", $dataDos);
                }
            }
        }else{
            $data = Caratula::caratula("Cambiar clave de acceso", false, false, false, "Tienda Virtual", $datas);
            $this->view("cambioClave", $data);
        }
    }
}
?>