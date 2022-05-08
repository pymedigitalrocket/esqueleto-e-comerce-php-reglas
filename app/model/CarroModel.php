<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'PHPMailer/vendor/autoload.php';

class CarroModel{
    private $db;

    function __construct(){
        $this->db = new MySQLdb();
    }

    public function verificarProducto($idProducto, $idUsuario){
        $sql = "SELECT * FROM carro WHERE id_usuario=".$idUsuario." ";
        $sql.= "AND id_producto=".$idProducto." ";
        $sql.= "AND estado=0";
        $respuesta = $this->db->querySelect($sql);
        return count($respuesta);
    }

    public function stock($idProducto){
        if(STOCK){
            $sql = "SELECT stock FROM producto WHERE id=".$idProducto;
            $datas = $this->db->query($sql);
            $stock = $datas["stock"];
            return $stock;
        }
    }

    function stockPositivo($idProducto, $cantidad){
        if(STOCK){
            $stock = $this->stock($idProducto);
            if($stock>=$cantidad){
                return true;
            }else{
                return false;
            }
        }
        return false;
    }

    public function agregarProducto($idProducto, $idUsuario){
        //estado 0 = carrito abierto
        if($this->stockPositivo($idProducto,1)){
            $sql = "SELECT * FROM producto WHERE id=".$idProducto." ";
            $datas = $this->db->query($sql);
            $sql = "INSERT INTO carro ";
            $sql.= "SET estado=0, ";
            $sql.= "id_producto=".$idProducto.", ";
            $sql.= "id_usuario=".$idUsuario.", ";
            $sql.= "cantidad=1, ";
            $sql.= "descuento=".$datas["descuento"].", ";
            $sql.= "fecha_compra=(NOW())";
            return $this->db->queryNoSelect($sql);
        }
        return false;
    }

    public function getCarro($idUsuario){
        $sql = "SELECT c.id_usuario as usuario, ";
        $sql.= "c.id_producto as producto, ";
        $sql.= "c.cantidad as cantidad, ";
        $sql.= "c.descuento as descuento, ";
        $sql.= "p.precio as precio, ";
        $sql.= "p.imagen1 as imagen, ";
        $sql.= "p.descripcion as descripcion, ";
        $sql.= "p.nombre as nombre ";
        $sql.= "FROM carro as c, producto as p ";
        $sql.= "WHERE id_usuario =".$idUsuario." AND ";
        $sql.= "estado=0 AND ";
        $sql.= "c.id_producto =p.id";
        return $this->db->querySelect($sql);
    }

    public function actualizar($idUsuario, $idProducto, $cantidad){
        if($this->stockPositivo($idProducto,$cantidad)){
            $sql = "UPDATE carro ";
            $sql.= "SET cantidad=".$cantidad." ";
            $sql.= "WHERE id_usuario =".$idUsuario." AND ";
            $sql.= "id_producto=".$idProducto." AND ";
            $sql.= "estado=0";
            return $this->db->queryNoSelect($sql);
        }
        return false;
    }

    public function borrar($idProducto, $idUsuario){
        $sql = "DELETE FROM carro WHERE id_usuario=".$idUsuario." AND id_producto=".$idProducto." AND estado=0";
        return $this->db->queryNoSelect($sql);
    }

    public function cierraCarro($idUsuario, $estado){
        //estado 0 carrito abierto
        //estado 1 carrito autorizado
        //estado 2 carrito cancelado
        //estado 3 carrito no autorizado
        $sql = "UPDATE carro ";
        $sql.= "SET estado=".$estado.", ";
        $sql.= "fecha_compra=(NOW()) ";
        $sql.= "WHERE id_usuario =".$idUsuario." AND ";
        $sql.= "estado=0";
        return $this->db->queryNoSelect($sql);
    }

    public function ventas($fechaInicio, $fechaMaxima, $productos, $categoria,$limiteInicial,$limiteFinal){
        $datasPrimerDia = $this->primerDiaMes();
        $primerDia = $datasPrimerDia["primer_dia_mes"];
        $datasUltimoDia = $this->ultimoDiaMes();
        $ultimoDia = $datasUltimoDia["ultimo_dia_mes"];
        $sql = "SELECT c.id_producto as producto, p.nombre as nombre_producto, p.categoria as categoria, c.id_usuario, ";
        $sql.= "SUM(p.precio*c.cantidad) as subtotal".", ";
        $sql.= "SUM(p.precio * (c.descuento/100) * c.cantidad) as descuento, ";
        $sql.= "SUM(p.precio*c.cantidad) - SUM(p.precio * (c.descuento/100) * c.cantidad) as total".", ";
        $sql.= "DATE(c.fecha_compra) as fecha ";
        $sql.= "FROM carro as c, producto as p ";
        $sql.= "WHERE c.id_producto=p.id AND ";
        $sql.= "c.estado=1 ";
        if(!empty($fechaInicio)&&!empty($fechaMaxima)){
            if($productos==1){
                $sql.= "AND date(c.fecha_compra) BETWEEN '".$fechaInicio."' AND '".$fechaMaxima."' ";
                $sql.= "GROUP BY p.nombre ";
                $sql.= "ORDER BY SUM(p.precio*c.cantidad) - SUM(p.precio * (c.descuento/100) * c.cantidad) DESC";
                $sql.= " limit ".$limiteInicial.",".$limiteFinal;
            }else if($categoria==1){
                $sql.= "AND date(c.fecha_compra) BETWEEN '".$fechaInicio."' AND '".$fechaMaxima."' ";
                $sql.= "GROUP BY p.categoria ";
                $sql.= "ORDER BY SUM(p.precio*c.cantidad) - SUM(p.precio * (c.descuento/100) * c.cantidad) DESC";
                $sql.= " limit ".$limiteInicial.",".$limiteFinal;
            }else{
                $sql.= "AND date(c.fecha_compra) BETWEEN '".$fechaInicio."' AND '".$fechaMaxima."' ";
                $sql.= "GROUP BY DATE(c.fecha_compra), id_usuario";
                $sql.= " limit ".$limiteInicial.",".$limiteFinal;
            }
        }else if($productos==1){
            $sql.= "AND date(c.fecha_compra) BETWEEN '".$primerDia."' AND '".$ultimoDia."' ";
            $sql.= "GROUP BY p.nombre ";
            $sql.= "ORDER BY SUM(p.precio*c.cantidad) - SUM(p.precio * (c.descuento/100) * c.cantidad) DESC";
            $sql.= " limit ".$limiteInicial.",".$limiteFinal;
        }else if($categoria==1){
            $sql.= "AND date(c.fecha_compra) BETWEEN '".$primerDia."' AND '".$ultimoDia."' ";
            $sql.= "GROUP BY p.categoria ";
            $sql.= "ORDER BY SUM(p.precio*c.cantidad) - SUM(p.precio * (c.descuento/100) * c.cantidad) DESC";
            $sql.= " limit ".$limiteInicial.",".$limiteFinal;
        }else{
            $sql.= "AND date(c.fecha_compra) BETWEEN '".$primerDia."' AND '".$ultimoDia."' ";
            $sql.= "GROUP BY DATE(c.fecha_compra), id_usuario";
            $sql.= " limit ".$limiteInicial.",".$limiteFinal;
        }
        return $this->db->querySelect($sql);
    }
    
    public function totalVentas($fechaInicio, $fechaMaxima, $productos, $categoria){
        $datasPrimerDia = $this->primerDiaMes();
        $primerDia = $datasPrimerDia["primer_dia_mes"];
        $datasUltimoDia = $this->ultimoDiaMes();
        $ultimoDia = $datasUltimoDia["ultimo_dia_mes"];
        $sql = Redundancia::paginacionModelVentas($fechaInicio, $fechaMaxima, $productos, $categoria,$primerDia,$ultimoDia);
        $datas = $this->db->querySelect($sql);
        return count($datas);
    }

    public function getCatalogos(){
        if(STOCK){
            $sql = "SELECT id, nombre FROM producto WHERE baja=0 AND status!=1 AND stock>0 ORDER BY nombre";
        }else{
            $sql = "SELECT id, nombre FROM producto WHERE baja=0 AND status!=1 ORDER BY nombre";
        }
        return $this->db->querySelect($sql);
    }

    public function getLlaves($tipo){
        $sql = "SELECT * FROM llave WHERE tipo='".$tipo. "' ORDER BY indice ASC";
        return $this->db->querySelect($sql);
    }

    public function detalle($fecha, $idUsuario){
        $sql = "SELECT p.nombre as nombre_producto, p.categoria as categoria, ";
        $sql.= "p.precio as precio, ";
        $sql.= "c.cantidad as cantidad, ";
        $sql.= "(p.precio * (c.descuento/100) * c.cantidad) as descuento, ";
        $sql.= "p.precio*c.cantidad as subtotal".", ";
        $sql.="p.precio*c.cantidad - p.precio * (c.descuento/100) * c.cantidad as total".", ";
        $sql.= "DATE(c.fecha_compra) as fecha ";
        $sql.= "FROM carro as c, producto as p ";
        $sql.= "WHERE c.id_producto=p.id AND ";
        $sql.= "c.estado=1 ";
        $sql.= "AND DATE(c.fecha_compra)='".$fecha."' ";
        $sql.= "AND c.id_usuario=".$idUsuario;
        $sql.= " GROUP BY p.nombre, c.fecha_compra";
        return $this->db->querySelect($sql);
    }

    public function detalleProductos($idProducto, $fechaInicio, $fechaMaxima){
        $datasPrimerDia = $this->primerDiaMes();
        $primerDia = $datasPrimerDia["primer_dia_mes"];
        $datasUltimoDia = $this->ultimoDiaMes();
        $ultimoDia = $datasUltimoDia["ultimo_dia_mes"];
        $sql = "SELECT p.nombre as nombre_producto, c.id_producto, ";
        $sql.= "p.precio as precio, ";
        $sql.= "c.cantidad as cantidad, ";
        $sql.= "(p.precio * (c.descuento/100) * c.cantidad) as descuento, ";
        $sql.= "p.precio * c.cantidad as subtotal, ";
        $sql.= "(p.precio*c.cantidad) - (p.precio * (c.descuento/100) * c.cantidad) as total, ";
        $sql.= "DATE(c.fecha_compra) as fecha ";
        $sql.= "FROM carro as c, producto as p ";
        $sql.= "WHERE c.id_producto=".$idProducto." AND ";
        $sql.= "c.estado=1 AND ";
        if(!empty($fechaInicio)&&!empty($fechaMaxima)){
            $sql.= "date(c.fecha_compra) BETWEEN '".$fechaInicio."' AND '".$fechaMaxima."' ";
        }else{
            $sql.= "date(c.fecha_compra) BETWEEN '".$primerDia."' AND '".$ultimoDia."' ";
        }
        $sql.= " GROUP BY c.fecha_compra";
        return  $this->db->querySelect($sql);
    }

    public function detalleCategorias($categoria, $fechaInicio, $fechaMaxima){
        $datasPrimerDia = $this->primerDiaMes();
        $primerDia = $datasPrimerDia["primer_dia_mes"];
        $datasUltimoDia = $this->ultimoDiaMes();
        $ultimoDia = $datasUltimoDia["ultimo_dia_mes"];
        $sql = "SELECT p.nombre as nombre_producto, c.id_producto, ";
        $sql.= "p.precio as precio, ";
        $sql.= "c.cantidad as cantidad, ";
        $sql.= "(p.precio * (c.descuento/100) * c.cantidad) as descuento, ";
        $sql.= "p.precio * c.cantidad as subtotal, ";
        $sql.= "(p.precio*c.cantidad) - (p.precio * (c.descuento/100) * c.cantidad) as total, ";
        $sql.= "DATE(c.fecha_compra) as fecha ";
        $sql.= "FROM carro as c, producto as p ";
        $sql.= "WHERE c.id_producto="."p.id"." AND ";
        $sql.= "p.categoria=".$categoria." AND ";
        $sql.= "c.estado=1 AND ";
        if(!empty($fechaInicio)&&!empty($fechaMaxima)){
            $sql.= "date(c.fecha_compra) BETWEEN '".$fechaInicio."' AND '".$fechaMaxima."' ";
        }else{
            $sql.= "date(c.fecha_compra) BETWEEN '".$primerDia."' AND '".$ultimoDia."' ";
        }
        $sql.= " GROUP BY c.fecha_compra, c.id_producto";
        return  $this->db->querySelect($sql);
    }

    public function ventasGrafica($fechaInicio, $fechaMaxima, $productos, $categoria,$limiteInicial,$limiteFinal){
        $datasPrimerDia = $this->primerDiaMes();
        $primerDia = $datasPrimerDia["primer_dia_mes"];
        $datasUltimoDia = $this->ultimoDiaMes();
        $ultimoDia = $datasUltimoDia["ultimo_dia_mes"];
        if($productos==1){
            $sql = "SELECT p.nombre as nombre_producto, ";
            $sql.= "SUM(p.precio*c.cantidad) - SUM(p.precio * (c.descuento/100) * c.cantidad) as total"." ";
        }else if($categoria==1){
            $sql = "SELECT p.categoria as categoria, ";
            $sql.= "SUM(p.precio*c.cantidad) - SUM(p.precio * (c.descuento/100) * c.cantidad) as total"." ";
        }else{
            $sql = "SELECT "."SUM(p.precio*c.cantidad) - SUM(p.precio * (c.descuento/100) * c.cantidad) as total".", ";
            $sql.= "DATE(c.fecha_compra) as fecha ";
        }
        $sql.= "FROM carro as c, producto as p ";
        $sql.= "WHERE c.id_producto=p.id AND c.estado=1 ";
        if(!empty($fechaInicio)&&!empty($fechaMaxima)){
            if($productos==1){
                $sql.= "AND date(c.fecha_compra) BETWEEN '".$fechaInicio."' AND '".$fechaMaxima."' ";
                $sql.= "GROUP BY p.nombre ";
                $sql.= "ORDER BY SUM(p.precio*c.cantidad) - SUM(p.precio * (c.descuento/100) * c.cantidad) DESC";
                $sql.= " limit ".$limiteInicial.",".$limiteFinal;
            }else if($categoria==1){
                $sql.= "AND date(c.fecha_compra) BETWEEN '".$fechaInicio."' AND '".$fechaMaxima."' ";
                $sql.= "GROUP BY p.categoria ";
                $sql.= "ORDER BY SUM(p.precio*c.cantidad) - SUM(p.precio * (c.descuento/100) * c.cantidad) DESC";
                $sql.= " limit ".$limiteInicial.",".$limiteFinal;
            }else{
                $sql.= "AND date(c.fecha_compra) BETWEEN '".$fechaInicio."' AND '".$fechaMaxima."' ";
                $sql.= "GROUP BY DATE(c.fecha_compra), id_usuario";
                $sql.= " limit ".$limiteInicial.",".$limiteFinal;
            }
        }else if($productos==1){
            $sql.= "AND date(c.fecha_compra) BETWEEN '".$primerDia."' AND '".$ultimoDia."' ";
            $sql.= "GROUP BY p.nombre ";
            $sql.= "ORDER BY SUM(p.precio*c.cantidad) - SUM(p.precio * (c.descuento/100) * c.cantidad) DESC";
            $sql.= " limit ".$limiteInicial.",".$limiteFinal;
        }else if($categoria==1){
            $sql.= "AND date(c.fecha_compra) BETWEEN '".$primerDia."' AND '".$ultimoDia."' ";
            $sql.= "GROUP BY p.categoria ";
            $sql.= "ORDER BY SUM(p.precio*c.cantidad) - SUM(p.precio * (c.descuento/100) * c.cantidad) DESC";
            $sql.= " limit ".$limiteInicial.",".$limiteFinal;
        }else{
            $sql.= "AND date(c.fecha_compra) BETWEEN '".$primerDia."' AND '".$ultimoDia."' ";
            $sql.= "GROUP BY DATE(c.fecha_compra), id_usuario";
            $sql.= " limit ".$limiteInicial.",".$limiteFinal;
        }
        return $this->db->querySelect($sql);
    }
    
    public function totalVentasGrafica($fechaInicio, $fechaMaxima, $productos, $categoria){
        $datasPrimerDia = $this->primerDiaMes();
        $primerDia = $datasPrimerDia["primer_dia_mes"];
        $datasUltimoDia = $this->ultimoDiaMes();
        $ultimoDia = $datasUltimoDia["ultimo_dia_mes"];
        $sql = Redundancia::paginacionModelGrafica($fechaInicio, $fechaMaxima, $productos, $categoria,$primerDia,$ultimoDia);
        $datas = $this->db->querySelect($sql);
        return count($datas);
    }

    function insertarTemporal($datas){
        $sql = "INSERT INTO usuario_temporal VALUES(0, ";
        $sql.= Redundancia::queryCarroTemporal($datas);
        $sql.= "(NOW()), ";
        if(isset($_SESSION["usuario"])){
            $sql.= "1, ";
        }else{
            $sql.= "2, ";
        }
        $sql.= "2)";
        return $this->db->queryNoSelect($sql);
    }

    function compraEfectiva($tipoUsuario){
        $datas = $this->getIDTemporal();
        $id = $datas["id"];
        if($tipoUsuario=="usuario logeado"){
            $sql = "UPDATE usuario_temporal SET tipo_usuario = 1, compra_efectiva = 1 WHERE id =".$id;
        }
        if($tipoUsuario=="usuario temporal"){
            $sql = "UPDATE usuario_temporal SET tipo_usuario = 2, compra_efectiva = 1 WHERE id =".$id;
        }
        return $this->db->queryNoSelect($sql);
    }

    function getIDTemporal(){
        $sql = "SELECT * FROM usuario_temporal WHERE id=(
            SELECT max(id) FROM usuario_temporal
            )";
        return $this->db->query($sql);
    }

    function actualizarMasVendido($idProducto, $cantidad){
        $sql = "SELECT mas_vendido FROM producto WHERE id = ".$idProducto;
        $datas = $this->db->query($sql);
        $masVendido = $datas["mas_vendido"];
        $masVendido = $masVendido + $cantidad;
        $sql = "UPDATE producto SET mas_vendido = ".$masVendido;
        $sql.= " WHERE id = ".$idProducto;
        return $this->db->queryNoSelect($sql);
    }

    function actualizarStock($idProducto, $cantidad){
        if(STOCK){
            $sql = "SELECT stock FROM producto WHERE id = ".$idProducto;
            $datas = $this->db->query($sql);
            $stock = $datas["stock"];
            $stock = $stock - $cantidad;
            $sql = "UPDATE producto SET stock = ".$stock;
            $sql.= " WHERE id = ".$idProducto;
            return $this->db->queryNoSelect($sql);
        }
    }

    function primerDiaMes(){
        $sql = "SELECT DATE_ADD(DATE_ADD(LAST_DAY(NOW()), INTERVAL 1 DAY),INTERVAL -1 MONTH) as primer_dia_mes";
        return $this->db->query($sql);
    }

    function ultimoDiaMes(){
        $sql = "SELECT LAST_DAY(NOW()) as ultimo_dia_mes";
        return $this->db->query($sql);
    }

    function getGracias($idUsuario){
        $sql = "SELECT id_producto, cantidad FROM carro ";
        $sql.= "WHERE id_usuario =".$idUsuario." AND ";
        $sql.= "estado=0";
        return $this->db->querySelect($sql);
    }

    function enviarCorreo($datas, $datasDos){
        $subTotal = 0;
        $descuento = 0;
        $porcentajeDescuento = 0;
        $remitente='contacto@tiendaprueba.cl';
        $msg = "<!doctype html>
        <html lang='en'>
          <head>
            <!-- Required meta tags -->
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1'>
          </head>
          <body>";

        $msg.= "Nombre: ".$datas["nombre"]." ".$datas["apellido_paterno"]."<br>";
        $msg.= "Direccion: ".$datas["direccion"]."<br>";
        $msg.= "Telefono: ".$datas["telefono"]."<br>";
        $msg.= "Correo: ".$datas["correo"]."<br>";

        $msg.= "<table width='100%'>";
        $msg.= "<tr>";
        $msg.= "<th width='25%'>Producto</th>";
        $msg.= "<th width='25%'>Cant.</th>";
        $msg.= "<th width='25%'>Precio</th>";
        $msg.= "<th width='25%'>Sub Total</th>";
        $msg.= "</tr>";
        for($i =0; $i<count($datasDos);$i++){
            $producto = $datasDos[$i]["producto"];
            $nombre = $datasDos[$i]["nombre"];
            $cantidad = $datasDos[$i]["cantidad"];
            $precio = $datasDos[$i]["precio"];
            $des = $datasDos[$i]["descuento"];
            if($des!=0){
                $porcentajeDescuento += ($precio * ($des/100))*$cantidad;
            }
            $total = $cantidad*$precio;
            $msg.= "<tr>";
            //producto
            $msg.= "<td>".$nombre."</td>";
            //cantidad
            $msg.= "<td>";
            $msg.= number_format($cantidad,0);
            $msg.= "<input type='hidden' name='i".$i."' value='".$producto."'/>";
            $msg.= "</td>";
            //precio
            $msg.= "<td>$".number_format($precio,0)."</td>";
            //total
            $msg.= "<td>$".number_format($total,0)."</td>";
            $subTotal += $total;
            $descuento += $des;
        }
        $total = $subTotal - $porcentajeDescuento;
        $msg.= "<input type='hidden' name='num' value='".$i."'/>";
        //$msg.= "<input type='hidden' name='idUsuario' value='".$data["datas"]["idUsuario"]."'/>";
        //$msg.= "</table>";
        $msg.= "<hr>";

        $msg.= "<table width='100%'>";
        $msg.= "<tr>";
        $msg.= "<td width='79.85%'></td>";
        $msg.= "<td width='11.55%'>Sub total</td>";
        $msg.= "<td width='9.20%'>$".number_format($subTotal,0)."</td>";
        $msg.= "</tr>";

        $msg.= "<tr>";
        $msg.= "<td></td>";
        $msg.= "<td>Descuento</td>";
        $msg.= "<td>$".number_format($porcentajeDescuento,0)."</td>";
        $msg.= "</tr>";
        $msg.= "<tr>";
        $msg.= "<td></td>";
        $msg.= "<td>Total</td>";
        $msg.= "<td>$".number_format($total,0)."</td>";
        $msg.= "</tr>";
        $msg.= "</table>";
        $msg.= "</body>
        </html>
        ";
        $mail = new PHPMailer(true);
        try{
            //Server settings
            $mail->SMTPDebug = '0';                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'mail.tiendaprueba.cl';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'contacto@tiendaprueba.cl';                     //SMTP username
            $mail->Password   = 'contactoprueba';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom($remitente); //remitente correo y nombre
            $mail->addAddress($datas["correo"],$datas["nombre"]); //destinatario correo y nombre 
            $mail->Subject = "Boleta Venta"; //asunto
            $mail->Body = $msg; //
            $mail->addCC($remitente);
        
            //Attachments
        
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
        
            $mail->send();
            return true;
        }catch (Exception $e){
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    }
}
?>