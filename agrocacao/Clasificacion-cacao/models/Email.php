<?php
include_once 'Conexion.php';

/*TODO: librerias necesarias para que el proyecto pueda enviar emails */
require '../include/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class email
{
    var $objetos;
    private $acceso;
    public function __construct()
    {
        $db = new conexion();
        $this->acceso = $db->pdo;
    }


    // TODO: CAMBIAR CONTRASEÑA
    function correo_recup($correo)
    {
        $sql = "SELECT * FROM usuario where email_us = :email_us";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':email_us' => $correo));
        $this->objetos = $query->fetch();
        if (!empty($this->objetos)) {
            $codigo = bin2hex(random_bytes(4));
            $sql = "UPDATE usuario SET codigo_recupe = :codigo_recupe, fecha_recupe = now() where email_us = :email_us";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':codigo_recupe' => $codigo, ':email_us' => $correo));
            
            $mail = new PHPMailer(true);

            try {
                // Configuración del servidor SMTP  
                //TODO: Configurar el mailer para usar SMTP                                    
                $mail->isSMTP();
                //TODO: Habilitar salida de depuración
                // SMTP::DEBUG_OF = off(for production use)0
                // SMTP::DEBUG_CLIENT = client messages 1
                // SMTP::DEBUG_SERVER = client and server messager 2
                $mail->SMTPDebug = 0;
                //TODO: Servidor SMTP                                          
                $mail->Host       = 'free.mboxhosting.com';
                //TODO: Puerto TCP para conectarse        
                $mail->Port       = 25; //o 465;  
                //TODO: Habilitar encriptación TLS, `PHPMailer::ENCRYPTION_SMTPS` también es aceptado                 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                //TODO: Habilitar autenticación SMTP                    
                $mail->SMTPAuth   = true;

                // Credenciales de la cuenta
                //TODO: Nombre de usuario SMTP                                
                $mail->Username   = 'agrocacao@agrocacao.net';
                //TODO: Contraseña SMTP                 
                $mail->Password   = 'Joker1234';


                // Ignorar verificación del certificado (solo para desarrollo)
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer'       => false,
                        'verify_peer_name'  => false,
                        'allow_self_signed' => true
                    )
                );


                // Recipientes
                // Añadir un destinatario
                $mail->setFrom('agrocacao@agrocacao.net', 'Agrocacao');
				$mail->addAddress($correo, 'Recuperacion');

                // Contenido
                // Configurar el email en formato HTML
                $mail->isHTML(true);
                //TODO: Establece la codificación de caracteres
                $mail->CharSet = 'UTF8';
                $mail->Subject = 'Recuperacion de Clave';
                $mail->Body    = '<h1>RECUPERACION DE CONTRASEÑA </h1><b>CODIGO:'.$codigo.'</b>';
                $mail->AltBody = 'AGROCACAO';

                // Archivos adjuntos
                // Añadir un archivo adjunto
                // $mail->addAttachment('/var/tmp/file.tar.gz');   
                // Nombre opcional            
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); 

                $mail->send();
                echo 'enviarcorreo';
            } catch (Exception $e) {
                // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                echo 'noenviarcorreo';
            }
            
        } else {
            echo 'noenviarcorreo';
        }
    }


    function recuperar_contra($correo, $cod_recup, $nuevo_pass){
        $sql = "SELECT * FROM usuario where email_us = :email_us AND codigo_recupe = :codigo_recupe";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':email_us' => $correo, ':codigo_recupe' => $cod_recup));
        $this->objetos = $query->fetch();
        if (!empty($this->objetos)) {
            $contraseña_segura = password_hash($nuevo_pass, PASSWORD_BCRYPT, ['cost' => 4]);
            $sql = "UPDATE usuario SET contrasena_us = :newpass, codigo_recupe = NULL where email_us = :email_us";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':email_us' => $correo, ':newpass' => $contraseña_segura));
            echo "codvalido";
        }else{
            echo "codinvalido";
        }
    }
}
