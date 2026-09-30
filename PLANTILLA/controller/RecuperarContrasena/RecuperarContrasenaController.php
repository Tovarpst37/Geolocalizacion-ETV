<?php

    include_once '../model/MasterModel.php';
    require '../../vendor/autoload.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    class RecuperarContrasenaController{

        public function recuperar(){

            $documentoR = $_POST['documentoR'];
    
            $obj = new MasterModel();
            $sql = "SELECT id_usuario, primer_nombre, correo FROM usuarios WHERE documento = '$documentoR'";
            $usuario = $obj->select($sql);
            
            if($usuario === null || empty($usuario[0]['correo'])){
                echo "<script> alert('Usuario incorrecto'); window.location = 'login.php'; </script>";
                return;
            }

            $destinatario = $usuario[0]['correo'];
            $codigo = $this->generarCodigoAleatorio();

            if(!$this->enviarCorreo($destinatario, $codigo, $usuario[0]['primer_nombre'])){
                echo "<script> alert('No se ha podido enviar el correo, por favor intentalo mas tarde'); window.location = 'login.php'; </script>";
                return;
            }

            $_SESSION['id_usuario']          = $usuario[0]['id_usuario'];
            $_SESSION['recuperacion_codigo']    = $codigo;
            $_SESSION['recuperacion_correo']    = $destinatario;
            $_SESSION['recuperacion_documento'] = $documentoR;
            $_SESSION['primer_nombre']          = $usuario[0]['primer_nombre'];
        
            echo "<script> alert('Codigo enviado correctamente a ".substr($destinatario, 0, 3)."***@gmail.com'); window.location = 'login.php?paso=codigo'; </script>";
        }

        public function validarCodigo(){

            $codigoIngresado = trim($_POST['codigo'] ?? '');

            if(!isset($_SESSION['recuperacion_codigo'])){
                echo "<script> alert('La sesion de recuperacion expiro, vuelve a intentarlo.'); window.location = 'login.php'; </script>";
                return;
            }

            if($codigoIngresado !== $_SESSION['recuperacion_codigo']){
                echo "<script> alert('Codigo incorrecto.'); window.location = 'login.php?paso=codigo'; </script>";
                return;
            }

            $_SESSION['auth'] = 'ok';
            unset($_SESSION['recuperacion_codigo']);
            unset($_SESSION['recuperacion_correo']);
            unset($_SESSION['recuperacion_documento']);

            redirect(getUrl("CambiarContrasena","CambiarContrasena","vsUpdatePassword"));            
        }

        public function cancelarRecuperacion(){
            unset($_SESSION['recuperacion_codigo']);
            unset($_SESSION['recuperacion_correo']);
            unset($_SESSION['recuperacion_documento']);
            unset($_SESSION['primer_nombre']);

            echo "<script> window.location = 'login.php'; </script>";
        }

        private function enviarCorreo($destinatario, $codigo, $nombre){

            $config = require '../config/mail.php';

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host       = $config['host'];
                $mail->SMTPAuth   = $config['smtp_auth'];
                $mail->Username   = $config['username'];
                $mail->Password   = $config['password'];
                $mail->SMTPSecure = $config['smtp_secure'];
                $mail->Port       = $config['port'];

                $mail->setFrom($config['from_email'], $config['from_name']);
                $mail->addAddress($destinatario);

                $mail->isHTML(true);
                $mail->Subject = 'Tu codigo de recuperacion de contrasena';
                $mail->Body    = "
                    <div style='font-family: Arial, sans-serif; max-width: 480px; margin: auto; padding: 24px; border: 1px solid #e0e0e0; border-radius: 8px;'>
                        <h2 style='color: #2c3e50;'>Hola, $nombre</h2>
                        <p>Recibimos una solicitud para recuperar tu contrasena. Usa el siguiente codigo para continuar:</p>
                        <div style='text-align: center; margin: 24px 0;'>
                            <span style='display: inline-block; font-size: 24px; font-weight: bold; letter-spacing: 2px; background: #f4f4f4; padding: 12px 24px; border-radius: 6px; color: #2c3e50;'>
                                $codigo
                            </span>
                        </div>
                        <p>Si tu no solicitaste este cambio, puedes ignorar este correo con tranquilidad, tu contrasena seguira igual.</p>
                        <hr style='border: none; border-top: 1px solid #e0e0e0; margin: 24px 0;'>
                        <p style='font-size: 12px; color: #999;'>Este es un mensaje automatico, por favor no respondas a este correo.</p>
                    </div>
                ";

                $mail->send();
                return true;

            } catch (Exception $e) {
                error_log("Error enviando correo: " . $mail->ErrorInfo);
                return false;
            }
        }
        
        private function generarCodigoAleatorio($longitud = 10) {
            $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            return substr(str_shuffle($caracteres), 0, $longitud);
        }
    }
?>