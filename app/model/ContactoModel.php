<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'PHPMailer/vendor/autoload.php';

class ContactoModel{
    private $db;

    function __construct(){
        $this->db = new MySQLdb();
    }
    function enviarCorreo($datas){
        $nombre = $datas["nombre"];
        $email = $datas["email"];
        $telefono = $datas["telefono"];
        $mensaje = $datas["mensaje"];
        // datos del correo remitente
        $remitente='contacto@tiendaprueba.cl';
        $carta = "De: $nombre \n" . "Telefono: $telefono \n" . "Correo: $email \n" . "Mensaje: $mensaje";

//Create an instance; passing `true` enables exceptions
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
    $mail->setFrom($remitente); //remitente correo y nombre
    $mail->addAddress($email,$nombre); //destinatario correo y nombre 
    $mail->Subject = 'Contacto'.' '.$nombre; //asunto
    $mail->Body = $carta; //
    $mail->addCC($remitente);

    //Attachments


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML

    $mail->send();
    return true;
} catch (Exception $e) {
    return false;
}

}

    }

?>