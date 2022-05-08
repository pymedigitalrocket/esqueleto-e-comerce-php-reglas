<?php

class ProductosAdmin extends Base{
    private $model;

    function __construct(){
        $this->model = $this->model("ProductosModel");
    }

    public function caratula(){
        $sesion = new Sesion();
        $total = 0;
        if($sesion->getLogin()){
            $totalProductos = $this->model->totalProductos();
            if($totalProductos<=1){
                $total = 1;
            }else{
                $total = $totalProductos/8;
                $total = ceil($total);
            }
            $datasDos = Redundancia::paginacionController('productos',8,$total);
            $categoria = $this->model->getLlaves("categoria");
            $datas = $this->model->getProductos($datasDos["limiteInicial"],8);
            $data = Caratula::caratula("Productos", false, true, true, "Admin", $datas);
            $dataDos = Caratula::caratulaCatalogoPaginacion($data,$categoria,$totalProductos);
            $this->view("productos", $dataDos);
        }else{
           header("Location:".RUTA."admin");
        }
    }

    public function insertarProducto(){
        $sesion = new Sesion();
        $datas = array();
        $errores = array();
        $status = $this->model->getLlaves("admonStatus");
        $catalogo = $this->model->getCatalogos();
        $talla = $this->model->getLlaves("talla");
        $categoria = $this->model->getLlaves("categoria");
        if($_SESSION["rol"]!=4){
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $id = isset($_POST["id"])?$_POST["id"]:"";
                $nombre = Valida::cadena(isset($_POST["nombre"])?$_POST["nombre"]:"");
                $descripcion = Valida::cadena(isset($_POST["content"])?$_POST["content"]:"");
                $marca = Valida::cadena(isset($_POST["marca"])?$_POST["marca"]:"");
                $talla = Valida::cadena(isset($_POST["talla"])?$_POST["talla"]:"");
                $material = Valida::cadena(isset($_POST["material"])?$_POST["material"]:"");
                $precio = Valida::validaNumeros(isset($_POST["precio"])?$_POST["precio"]:"0");
                $imagen1 = $_FILES['imagen1']['name'];
                if(!empty($imagen1)){
                    $imagen1 = Valida::archivo($imagen1);
                    $imagen1.= strtolower($imagen1.".jpg");
                }
                $imagen2 = $_FILES['imagen2']['name'];
                if(!empty($imagen2)){
                    $imagen2 = Valida::archivo($imagen2);
                    $imagen2.= strtolower($imagen2.".jpg");
                }
                $imagen3 = $_FILES['imagen3']['name'];
                if(!empty($imagen3)){
                    $imagen3 = Valida::archivo($imagen3);
                    $imagen3.= strtolower($imagen3.".jpg");
                }
                $relacion1 = isset($_POST["relacion1"])?$_POST["relacion1"]:"";
                $relacion2 = isset($_POST["relacion2"])?$_POST["relacion2"]:"";
                $relacion3 = isset($_POST["relacion3"])?$_POST["relacion3"]:"";
                $categoria = isset($_POST["categoria"])?$_POST["categoria"]:"";
                $descuento = Valida::validaNumeros(isset($_POST["descuento"])?$_POST["descuento"]:"0");
                $stock = Valida::validaNumeros(isset($_POST["stock"])?$_POST["stock"]:"0");
                $status = isset($_POST["status"])?$_POST["status"]:"";
    
                if(empty($nombre)){
                    array_push($errores,"El nombre es requerido");
                }
                if(!empty($precio)){
                    if(!is_numeric($precio)){
                        array_push($errores,"El precio debe ser un numero");
                    }
                }else{
                    array_push($errores,"El precio es requerido");
                }
                if(!empty($imagen1)){
                    if(Valida::archivoImagen($_FILES['imagen1']['tmp_name'])){
                        $imagen1 = Valida::archivo(html_entity_decode($nombre));
                        $imagen1 = strtolower($imagen1.".jpg");
                        if(is_uploaded_file($_FILES['imagen1']['tmp_name'])){
                            if(copy($_FILES['imagen1']['tmp_name'],"img/".$imagen1)){
                                Valida::esImagen($imagen1,400, 300);
                            }else{
                                array_push($errores, "nombre de imagen no valido (asegurese de ingresar un nombre de producto valido)");
                            }
                        }else{
                            array_push($errores,"Error al subir la imagen");
                        }
                    }else{
                        array_push($errores,"Imagen no valida");
                    }
                }else{
                    array_push($errores,"la imagen es requerida");
                }
                if(!empty($imagen2)){
                    if(Valida::archivoImagen($_FILES['imagen2']['tmp_name'])){
                        $imagen2 = Valida::archivo(html_entity_decode($nombre));
                        $imagen2 = strtolower($imagen2."Dos".".jpg");
                        if(is_uploaded_file($_FILES['imagen2']['tmp_name'])){
                            if(copy($_FILES['imagen2']['tmp_name'],"img/".$imagen2)){
                                Valida::esImagen($imagen2,400,300);
                            }else{
                                array_push($errores, "nombre de imagen no valido (asegurese de ingresar un nombre de producto valido)");
                            }
                        }else{
                            array_push($errores,"Error al subir la imagen");
                        }
                    }else{
                        array_push($errores,"Imagen no valida");
                    }
                }
                if(!empty($imagen3)){
                    if(Valida::archivoImagen($_FILES['imagen3']['tmp_name'])){
                        $imagen3 = Valida::archivo(html_entity_decode($nombre));
                        $imagen3 = strtolower($imagen3."Tres".".jpg");
                        if(is_uploaded_file($_FILES['imagen3']['tmp_name'])){
                            if(copy($_FILES['imagen3']['tmp_name'],"img/".$imagen3)){
                                Valida::esImagen($imagen3,400,300);
                            }else{
                                array_push($errores, "nombre de imagen no valido (asegurese de ingresar un nombre de producto valido)");
                            }
                        }else{
                            array_push($errores,"Error al subir la imagen");
                        }
                    }else{
                        array_push($errores,"Imagen no valida");
                    }
                }
                if(!empty($descuento)){
                    if(!is_numeric($descuento)){
                        array_push($errores,"El descuento debe ser un numero");
                    }
                }else{
                    $descuento = "0";
                }
                if($precio < $descuento){
                    array_push($errores,"El precio no puede ser menor que el descuento");
                }
                if(!empty($stock)){
                    if(!is_numeric($stock)){
                        array_push($errores,"El stock debe ser un numero");
                    }
                }else{
                    $stock = "0";
                }
                if($relacion1=="void"){
                    $relacion1 = 0;
                }
                if($relacion2=="void"){
                    $relacion2 = 0;
                }
                if($relacion3=="void"){
                    $relacion3 = 0;
                }
                if($categoria=="void"){
                    $categoria = 0;
                }
                if($talla=="void"){
                    array_push($errores,"Es necesario que le de una talla a la prenda");
                }
                if($status==1||$status==2){
                    $nada = "";
                }else{
                    array_push($errores,"debe seleccionar el status del producto");
                }
    
                $datas = [
                    "id" => $id,
                    "nombre" => $nombre,
                    "descripcion" => $descripcion,
                    "marca" => $marca,
                    "talla" => $talla,
                    "material" => $material,
                    "precio" => $precio,
                    "imagen1" => $imagen1,
                    "imagen2" => $imagen2,
                    "imagen3" => $imagen3,
                    "relacion1" => $relacion1,
                    "relacion2" => $relacion2,
                    "relacion3" => $relacion3,
                    "categoria" => $categoria,
                    "descuento" => $descuento,
                    "stock" => $stock,
                    "status" => $status
                ];
    
                if(empty($errores)){
                    if(empty($id)){
                        if($this->model->insertarProducto($datas)){
                            header("Location:".RUTA."productosAdmin");
                        }else{
                            $data = Caratula::caratula("Error al registrar el Producto", false, true, true, "Admin");
                            $dataDos = Caratula::caratulaError($data, "Lo sentimos, algo salio mal", "Error. Algo salio mal al momento de su registro", "alert-danger", "productosAdmin", "btn-primary", "Regresar");
                            $this->view("mensaje", $dataDos);
                        }
                    }else{
                        if($this->model->editarProducto($datas)){
                            header("Location:".RUTA."productosAdmin");
                        }else{
                            $data = Caratula::caratula("Eror al modificar el Producto", false, true, true, "Admin");
                            $dataDos = Caratula::caratulaError($data, "Lo sentimos, algo salio mal", "Error. Algo salio mal al momento de la modificacion", "alert-danger", "productosAdmin", "btn-primary", "Regresar");
                            $this->view("mensaje", $dataDos);
                        }
                    }        
                }else{
                    $tipoProducto = $this->model->getLlaves("tipoProducto");
                    $status = $this->model->getLlaves("admonStatus");
                    $catalogo = $this->model->getCatalogos();
                    $data = Caratula::caratula("Registro Producto", false, true, true, "Admin", $datas, $errores);
                    $dataDos = Caratula::caratulaConTodo($data, $tipoProducto, $status, $catalogo, "Registro Producto");
                    $this->view("registroProducto", $dataDos);
                }
            }else{
                $data = Caratula::caratula("Registro Producto", false, true, true, "Admin", $datas);
                $dataDos = Caratula::caratulaProducto($data, $status, $catalogo, $talla, $categoria, "Registro Producto"); 
                $this->view("registroProducto", $dataDos);
            }
        }else{
            $data = Caratula::caratula("Acceso restringido", false, true, true, "Admin");
            $dataDos = Caratula::caratulaError($data, "Lo sentimos, ud no tiene acceso aqui", "Su rol de usuario no le permite esta accion", "alert-danger", "productosAdmin", "btn-primary", "Regresar");
            $this->view("mensaje", $dataDos);
        }
    }

    public function borrarProducto($id=""){
        $sesion = new Sesion();
        if($_SESSION["rol"]!=4){
            $status = $this->model->getLlaves("admonStatus");
            $catalogo = $this->model->getCatalogos();
            $talla = $this->model->getLlaves("talla");
            $categoria = $this->model->getLlaves("categoria");
            $datas = $this->model->getProductosID($id);
            $data = Caratula::caratula("Borrar Producto", false, true, true, "Admin", $datas);
            $dataDos = Caratula::caratulaProductoConTodo($data, $status, $catalogo, $talla, $categoria, "Borrar Producto", true);
            $this->view("registroProducto", $dataDos);
        }else{
            $data = Caratula::caratula("Acceso restringido", false, true, true, "Admin");
            $dataDos = Caratula::caratulaError($data, "Lo sentimos, ud no tiene acceso aqui", "Su rol de usuario no le permite esta accion", "alert-danger", "productosAdmin", "btn-primary", "Regresar");
            $this->view("mensaje", $dataDos);
        }
    }

    public function borrarLogico($id=""){
        if(!empty($id)){
            if($this->model->borrarLogico($id)){
                header("Location:".RUTA."productosAdmin");
            }
        }
    }

    public function editarProducto($id=""){
        $sesion = new Sesion();
        if($_SESSION["rol"]!=4){
            $status = $this->model->getLlaves("admonStatus");
            $catalogo = $this->model->getCatalogos();
            $talla = $this->model->getLlaves("talla");
            $categoria = $this->model->getLlaves("categoria");
            $datas = $this->model->getProductosID($id);
            $data = Caratula::caratula("Modificar Producto", false, true, true, "Admin", $datas);
            $dataDos = Caratula::caratulaProducto($data, $status, $catalogo, $talla, $categoria, "Modificar Producto");
            $this->view("registroProducto", $dataDos);
        }else{
            $data = Caratula::caratula("Acceso restringido", false, true, true, "Admin");
            $dataDos = Caratula::caratulaError($data, "Lo sentimos, ud no tiene acceso aqui", "Su rol de usuario no le permite esta accion", "alert-danger", "productosAdmin", "btn-primary", "Regresar");
            $this->view("mensaje", $dataDos);
        }
    }

    public function getMasVendidos(){
        return $this->model->getMasVendidos();
    }

    public function getNuevos(){
        return $this->model->getNuevos();
    }

    public function producto($id="", $regresa=""){
        $sesion = new Sesion();
        $datas = $this->model->getProductosID($id);
        $tallas = $this->model->getLlaves("talla");
        $categoria = $this->model->getLlaves("categoria");
        $catalogo = $this->model->getCatalogos();
        if(isset($_SESSION["usuario"])){
            $idUsuario = $_SESSION["usuario"]["id"];
            $data = Caratula::caratula("Detalle Producto", true, false, false, "Tienda Virtual", $datas);
            $dataDos = Caratula::caratulaIdMas($data, $idUsuario, $datas["nombre"], $regresa, $tallas,$categoria, $catalogo);
            $this->view("producto", $dataDos);
        }else{
            $idTemporal = $_SESSION["temporal"];
            $data = Caratula::caratula("Detalle Producto", true, false, false, "Tienda Virtual", $datas);
            $dataDos = Caratula::caratulaIdMas($data, $idTemporal, $datas["nombre"], $regresa, $tallas,$categoria, $catalogo);
            $this->view("producto", $dataDos);  
        }
    }
}
?>