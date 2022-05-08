<?php

class AdminUsuarios extends Base{
    private $model;

    function __construct(){
        $this->model = $this->model("AdminUsuariosModel");
    }

    public function caratula(){
        $sesion = new Sesion();
        $total = 0;
        if($sesion->getLogin()){
            $totalAdmon = $this->model->totalUsuarios();
            if($totalAdmon<=1){
                $total = 1;
            }else{
                $total = $totalAdmon/8;
                $total = ceil($total);
            }
            $datasDos = Redundancia::paginacionController('admon',8,$total);
            $datas = $this->model->getUsers($datasDos["limiteInicial"],8);
            $data = Caratula::caratula("Usuarios", false, true, true, "Admin", $datas);
            $dataDos = Caratula::caratulaPagina($data,$totalAdmon);
            $this->view("adminUsuarioVista", $dataDos);
        }else{
            header("Location:".RUTA."loginAdmin");
        }
    }

    public function registroUsuario(){
        $sesion = new Sesion();
        $llaves = $this->model->getLlaves("admonStatus");
        $rol = $this->model->getLlaves("tipoUsuarioAdmon");
        if($_SESSION["rol"]==1||$_SESSION["rol"]==2){
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                $errores = array();
                $datas = array();
                $id = isset($_POST['id'])?$_POST['id']:"";
                $nombre = Valida::cadena(isset($_POST["nombre"])?$_POST["nombre"]:"");
                $correo = Valida::cadena(isset($_POST["correo"])?$_POST["correo"]:"");
                $clave1 = Valida::cadena(isset($_POST["clave1"])?$_POST["clave1"]:"");
                $clave2 = Valida::cadena(isset($_POST["clave2"])?$_POST["clave2"]:"");
                $tipoUsuarioAdmon = isset($_POST["tipoUsuarioAdmon"])?$_POST["tipoUsuarioAdmon"]:"";
                $status = isset($_POST["status"])?$_POST["status"]:"";
                if(empty($nombre)){
                    array_push($errores,"El nombre es requerido");
                }
                if(empty($correo)){
                    array_push($errores,"El email es requerido");
                }
                if(empty($clave1)){
                    array_push($errores,"La clave de acceso es requerida");
                }
                if(empty($clave2)){
                    array_push($errores,"Debe verificar la clave de acceso");
                }
                if($clave1!==$clave2){
                    array_push($errores,"Las claves no coinciden");
                }
                if(!filter_var($correo, FILTER_VALIDATE_EMAIL)){
                    array_push($errores, "El correo electronico no es valido");
                }
                if($tipoUsuarioAdmon=="void"){
                    array_push($errores, "debe escoger el tipo de usuario administrativo");
                }
                $datas = [
                    "id" => $id,
                    "nombre" => $nombre,
                    "correo" => $correo,
                    "clave1" => $clave1,
                    "clave2" => $clave2,
                    "tipoUsuarioAdmon" => $tipoUsuarioAdmon,
                    "status" => $status
                ];
                if(empty($errores)){
                    if(empty($id)){
                        $errores = $this->model->verificarEmail($datas);
                        if(empty($errores)){
                            if($this->model->insertarUsuarioAdmin($datas)){
                                $datas = $this->model->getUsersNoLimit();
                                $data = Caratula::caratula("Registro Usuario Administrativo", false, true, true, "Admin", $datas);
                                $dataDos = Caratula::caratulaSubtitulo($data, "Registro Usuario Administrativo");
                                $this->view("adminUsuarioVista",$dataDos);
                            }else{
                                $data = Caratula::caratula("Error al registrar el Usuario Administrativo", false, true, true, "Admin");
                                $dataDos = Caratula::caratulaError($data, "Lo sentimos, algo salio mal", "Error. Algo salio mal al momento de su registro", "alert-danger", "adminUsuarios", "btn-primary", "Regresar");
                                $this->view("mensaje", $dataDos);
                            }
                        }else{
                            $data = Caratula::caratula("Registro Usuario Administrativo", false, true, true, "Admin", $datas, $errores);
                            $dataDos = Caratula::caratulaSubtitulo($data, "Registro Usuario Administrativo");
                            $this->view("adminUsuarios",$dataDos);
                        }
                    }else{
                        if($status=="void"){
                            array_push($errores, "debe escoger el status del usuario administrativo");
                        }
                        if(empty($errores)){
                            $errores = $this->model->editarUsuario($datas);
                            if(empty($errores)){
                                $datas = $this->model->getUsersNoLimit();
                                $data = Caratula::caratula("Perfil Administrativo", false, true, true, "Admin", $datas);
                                $this->view("adminUsuarioVista",$data);
                            }else{
                                $data = Caratula::caratula("Modificar Usuario Administrativo", false, true, true, "Admin", $datas, $errores);
                                $dataDos = Caratula::caratulaConTodo($data, $llaves, $rol, "Modificar Usuario Administrativo");
                                $this->view("adminUsuarios",$dataDos);
                            }
                        }
                    }
                }else{
                    if(empty($id)){
                        $data = Caratula::caratula("Registro Usuario Administrativo", false, true, true, "Admin", $datas, $errores);
                        $dataDos = Caratula::caratulaConTodo($data, $llaves, $rol, "Registro Usuario Administrativo");
                        $this->view("adminUsuarios",$dataDos);
                    }else{
                        $data = Caratula::caratula("Modificar Usuario Administrativo", false, true, true, "Admin", $datas, $errores);
                        $dataDos = Caratula::caratulaConTodo($data, $llaves, $rol, "Modificar Usuario Administrativo");
                        $this->view("adminUsuarios",$dataDos);
                    }
                }
            }else{
                $llaves = $this->model->getLlaves("admonStatus");
                $rol = $this->model->getLlaves("tipoUsuarioAdmon");
                if(empty($id)){
                    $data = Caratula::caratula("Registro Usuario Administrativo", false, true, true, "Admin",$rol);
                    $dataDos = Caratula::caratulaConTodo($data, $llaves, $rol, "Registro Usuario Administrativo");
                    $this->view("adminUsuarios",$dataDos);
                }else{
                    $data = Caratula::caratula("Modificar Usuario Administrativo", false, true, true, "Admin",$datas);
                    $dataDos = Caratula::caratulaConTodo($data, $llaves, $rol, "Modificar Usuario Administrativo");
                    $this->view("adminUsuarios",$dataDos);
                }
            }
        }else{
            $data = Caratula::caratula("Acceso restringido", false, true, true, "Admin");
            $dataDos = Caratula::caratulaError($data, "Lo sentimos, ud no tiene acceso aqui", "Su rol de usuario no le permite esta accion", "alert-danger", "adminUsuarios", "btn-primary", "Regresar");
            $this->view("mensaje", $dataDos);
        }
    }

    public function editarUsuario($id=""){
        $sesion = new Sesion();
        if($_SESSION["rol"]==1||$_SESSION["rol"]==2){
            $status = $this->model->getLlaves("admonStatus");
            $rol = $this->model->getLlaves("tipoUsuarioAdmon");
            $datas = $this->model->getUsersID($id);
            $rolAdmin = $datas["tipo_usuario_admon"];
            if($_SESSION["rol"]==1&&$rolAdmin!=1){
                $data = Caratula::caratula("Modificar Usuario Administrativo", false, true, true, "Admin", $datas);
                $dataDos = Caratula::caratulaConTodo($data, $status, $rol, "Modificar Usuario Administrativo");
                $this->view("adminUsuarios", $dataDos);
            }else if($_SESSION["rol"]==2&&($rolAdmin!=1&&$rolAdmin!=2)){
                $data = Caratula::caratula("Modificar Usuario Administrativo", false, true, true, "Admin", $datas);
                $dataDos = Caratula::caratulaConTodo($data, $status, $rol, "Modificar Usuario Administrativo");
                $this->view("adminUsuarios", $dataDos);
            }else{
                $data = Caratula::caratula("Acceso restringido", false, true, true, "Admin");
                $dataDos = Caratula::caratulaError($data, "Lo sentimos, ud no tiene acceso aqui", "Su rol de usuario no le permite esta accion", "alert-danger", "adminUsuarios", "btn-primary", "Regresar");
                $this->view("mensaje", $dataDos);
            }
        }else{
            $data = Caratula::caratula("Acceso restringido", false, true, true, "Admin");
            $dataDos = Caratula::caratulaError($data, "Lo sentimos, ud no tiene acceso aqui", "Su rol de usuario no le permite esta accion", "alert-danger", "adminUsuarios", "btn-primary", "Regresar");
            $this->view("mensaje", $dataDos);
        }
    }

    public function borrarUsuario($id=""){
        $sesion = new Sesion();
        if($_SESSION["rol"]==1||$_SESSION["rol"]==2){
            $status = $this->model->getLlaves("admonStatus");
            $rol = $this->model->getLlaves("tipoUsuarioAdmon");
            $datas = $this->model->getUsersID($id);
            $rolAdmin = $datas["tipo_usuario_admon"];
            if($_SESSION["rol"]==1&&$rolAdmin!=1){
                $data = Caratula::caratula("Borrar Usuario Administrativo", false, true, true, "Admin", $datas);
                $dataDos = Caratula::caratulaConTodoMas($data, $status, $rol, "Borrar Usuario Administrativo",true);
                $this->view("adminUsuarios", $dataDos);
            }else if($_SESSION["rol"]==2&&($rolAdmin!=1&&$rolAdmin!=2)){
                $data = Caratula::caratula("Borrar Usuario Administrativo", false, true, true, "Admin", $datas);
                $dataDos = Caratula::caratulaConTodoMas($data, $status, $rol, "Borrar Usuario Administrativo",true);
                $this->view("adminUsuarios", $dataDos);
            }else{
                $data = Caratula::caratula("Acceso restringido", false, true, true, "Admin");
                $dataDos = Caratula::caratulaError($data, "Lo sentimos, ud no tiene acceso aqui", "Su rol de usuario no le permite esta accion", "alert-danger", "adminUsuarios", "btn-primary", "Regresar");
                $this->view("mensaje", $dataDos);
            }
        }else{
            $data = Caratula::caratula("Acceso restringido", false, true, true, "Admin");
            $dataDos = Caratula::caratulaError($data, "Lo sentimos, ud no tiene acceso aqui", "Su rol de usuario no le permite esta accion", "alert-danger", "adminUsuarios", "btn-primary", "Regresar");
            $this->view("mensaje", $dataDos);
        }
    }

    public function borrarLogico($id=""){
        if(!empty($id)){
            if(empty($this->model->borrarLogico($id))){
                $datas = $this->model->getUsersNoLimit();
                $data = Caratula::caratula("Usuarios", false, true, true, "Admin", $datas);
                $this->view("adminUsuarioVista",$data);
            }
        }
    }
}
?>