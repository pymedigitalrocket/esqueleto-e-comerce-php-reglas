<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'PHPMailer/vendor/autoload.php';

class LoginModel{
    private $db;

    function __construct(){
        $this->db = new MySQLdb();
    }

    function insertar($datas){
        $respuesta = false;
        if ($this->validaCorreo($datas["email"])) {
            $clave = hash_hmac("sha256", $datas["clave1"], "mimamamemima");
            $fechaVacia = "0000-00-00 00:00:00";
            $sql = "INSERT INTO usuario VALUES(0, ";
            $sql.= Redundancia::queryCarroTemporal($datas);
            $sql.= "'".$clave."', ";
            $sql.= "1, ";
            $sql.= "0, ";
            $sql.= "(NOW()), ";
            $sql.= "'".$fechaVacia."', ";
            $sql.= "'".$fechaVacia."')";
            $respuesta = $this->db->queryNoSelect($sql);
        } 
        return $respuesta;
    }

    function validaCorreo($email){
        $sql = "SELECT * FROM usuario WHERE email='".$email."'";
        $datas = $this->db->query($sql);
        return empty($datas)?true:false;
    }

    function getCorreo($email){
        $sql = "SELECT * FROM usuario WHERE email='".$email."'";
        $datas = $this->db->query($sql);
        return $datas;
    }

    function enviarCorreo($email){
        $datas = $this->getCorreo($email);
        $id = $datas["id"];
        $nombre = $datas["nombre"]." ".$datas["apellidoPaterno"];
        $msg = $nombre." entra al siguiente enlace para recuperar tu contrase単a en la tienda virtual<br>";
        $msg.="<a href='"."http://tiendaprueba.cl".RUTA."login/cambioclave/".$id."'>cambia tu clave de acceso</a>";
        $mail = new PHPMailer(true);

        try {
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
            $mail->setFrom('contacto@tiendaprueba.cl'); //remitente correo y nombre
            $mail->addAddress($email,$nombre); //destinatario correo y nombre 
            $mail->Subject = 'Cambio de contraseña'; //asunto
            $mail->Body = $msg; //
        
            //Attachments
        
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
        
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function cambiarClave($id, $clave){
        $respuesta = false;
        $clave = hash_hmac("sha256", $clave, "mimamamemima");
        $sql = "UPDATE usuario SET ";
        $sql.= "clave ='".$clave."' ";
        $sql.= "WHERE id=".$id;
        $respuesta = $this->db->queryNoSelect($sql); 
        return $respuesta;
    }

    function verificar($email, $clave){
        $errores = array();
        $sql = "SELECT * FROM usuario WHERE status=1 AND baja=0 AND email='".$email."'";
        $clave = hash_hmac("sha256", $clave, "mimamamemima");
        $datas = $this->db->query($sql);
        $clave = substr($clave, 0,200);
        if(empty($datas)){
            array_push($errores,"no existe el Email");
        }else if($clave!=$datas["clave"]){
            array_push($errores,"contrase単a no valida");
        }
        return $errores;
    }
}
?>