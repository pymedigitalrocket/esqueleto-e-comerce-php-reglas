<?php

class AdminClientes extends Base{
    private $model;

    function __construct(){
        $this->model = $this->model("AdminClientesModel");
    }

    public function caratula(){
        $sesion = new Sesion();
        $total = 0;
        if($sesion->getLogin()){
            $totalClientes = $this->model->totalClientes();
            if($totalClientes<=1){
                $total = 1;
            }else{
                $total = $totalClientes/8;
                $total = ceil($total);
            }
            $datasDos = Redundancia::paginacionController('clientes',8,$total);
            $datas = $this->model->getClientes($datasDos["limiteInicial"],8);
            $data = Caratula::caratula("Clientes", false, true, true, "Admin", $datas);
            $dataDos = Caratula::caratulaPagina($data,$totalClientes);
            $this->view("adminClientesVista", $dataDos);
        }else{
            header("Location:".RUTA."loginAdmin");
        }
    }

    public function registroCliente(){
        $sesion = new Sesion();
        if($_SESSION["rol"]!=4){
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
                    array_push($errores, "Confirme su contrase単a");
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
                    if(empty($id)){
                        $errores = $this->model->verificarEmail($datas);
                        if(empty($errores)){
                            if($this->model->insertarCliente($datas)){
                                $datas = $this->model->getClientesNoLimit();
                                $data = Caratula::caratula("Registro Cliente", false, true, true, "Admin", $datas);
                                $dataDos = Caratula::caratulaSubtitulo($data, "Registro Cliente");
                                $this->view("adminClientesVista",$dataDos);
                            }else{
                                $data = Caratula::caratula("Error al registrar el cliente", false, true, true, "Admin");
                                $dataDos = Caratula::caratulaError($data, "Lo sentimos, algo salio mal", "Error. Algo salio mal al momento de su registro", "alert-danger", "adminClientes", "btn-primary", "Regresar");
                                $this->view("mensaje", $dataDos);
                            }
                        }else{
                            $data = Caratula::caratula("Registro Cliente", false, true, true, "Admin", $datas, $errores);
                            $dataDos = Caratula::caratulaSubtitulo($data, "Registro Cliente");
                            $this->view("registroCliente",$dataDos);
                        }
                    }else{
                        if($status==1||$status==2){
                            $nada = "";
                        }else{
                            array_push($errores, "debe escoger el status del usuario");
                        }
                        $errores = $this->model->editarCliente($datas);
                        if(empty($errores)){
                            $datas = $this->model->getClientesNoLimit();
                            $data = Caratula::caratula("Perfil Administrativo", false, true, true, "Admin", $datas);
                            $this->view("adminClientesVista",$data);
                        }else{
                            $data = Caratula::caratula("Error al modificar el Cliente", false, true, true, "Admin");
                            $dataDos = Caratula::caratulaError($data, "Lo sentimos, algo salio mal", "Error. Algo salio mal al momento de modificar", "alert-danger", "adminClientes", "btn-primary", "Regresar");
                            $this->view("mensaje", $dataDos);
                        }
                    }
                }else{
                    $llaves = $this->model->getLlaves("admonStatus");
                    if(empty($id)){
                        $data = Caratula::caratula("Registro Cliente", false, true, true, "Admin", $datas, $errores);
                        $dataDos = Caratula::caratulaLlaves($data, $llaves, "Registro Cliente");
                        $this->view("registroCliente",$dataDos);
                    }else{
                        $data = Caratula::caratula("Modificar Cliente", false, true, true, "Admin", $datas, $errores);
                        $dataDos = Caratula::caratulaLlaves($data, $llaves, "Modificar Cliente");
                        $this->view("registroCliente",$dataDos);
                    }
                }
            }else{
                $llaves = $this->model->getLlaves("admonStatus");
                $data = Caratula::caratula("Registro Cliente", false, true, true, "Admin");
                $dataDos = Caratula::caratulaLlaves($data, $llaves, "Registro Cliente");
                $this->view("registroCliente",$dataDos);
            }
        }else{
            $data = Caratula::caratula("Acceso restringido", false, true, true, "Admin");
            $dataDos = Caratula::caratulaError($data, "Lo sentimos, ud no tiene acceso aqui", "Su rol de usuario no le permite esta accion", "alert-danger", "adminClientes", "btn-primary", "Regresar");
            $this->view("mensaje", $dataDos);
        }
    }

    public function editarCliente($id=""){
        $sesion = new Sesion();
        if($_SESSION["rol"]!=4){
            $status = $this->model->getLlaves("admonStatus");
            $datas = $this->model->getClienteID($id);
            $data = Caratula::caratula("Modificar Cliente", false, true, true, "Admin", $datas);
            $dataDos = Caratula::caratulaLlaves($data, $status, "Modificar Cliente");
            $this->view("registroCliente", $dataDos);
        }else{
            $data = Caratula::caratula("Acceso restringido", false, true, true, "Admin");
            $dataDos = Caratula::caratulaError($data, "Lo sentimos, ud no tiene acceso aqui", "Su rol de usuario no le permite esta accion", "alert-danger", "adminClientes", "btn-primary", "Regresar");
            $this->view("mensaje", $dataDos);
        }
    }

    public function borrarCliente($id=""){
        $sesion = new Sesion();
        if($_SESSION["rol"]!=4){
            $status = $this->model->getLlaves("admonStatus");
            $datas = $this->model->getClienteID($id);
            $data = Caratula::caratula("Borrar Cliente", false, true, true, "Admin", $datas);
            $dataDos = Caratula::caratulaStatus($data, $status, true, "Borrar Cliente");
            $this->view("registroCliente", $dataDos);
        }else{
            $data = Caratula::caratula("Acceso restringido", false, true, true, "Admin");
            $dataDos = Caratula::caratulaError($data, "Lo sentimos, ud no tiene acceso aqui", "Su rol de usuario no le permite esta accion", "alert-danger", "adminClientes", "btn-primary", "Regresar");
            $this->view("mensaje", $dataDos); 
        }
    }

    public function borrarLogico($id=""){
        if(!empty($id)){
            if(empty($this->model->borrarLogico($id))){
                $datas = $this->model->getClientesNoLimit();
                $data = Caratula::caratula("Clientes", false, true, true, "Admin", $datas);
                $this->view("adminClientesVista",$data);
            }
        }
    }
}
?>