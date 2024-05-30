<?php
require_once "vendor/autoload.php";
require_once "config.php";
require_once "Conexion.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$conn = new Connection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);


function generateSixDigitCode() {
    return random_int(100000, 999999);
}

// Ejemplo de uso
$code = generateSixDigitCode();

// Configurar el objeto PHPMailer
$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';

try {
    // Configuración del servidor de correo
    $mail->isSMTP();
    $mail->Host = mail_server;
    $mail->SMTPAuth = true;
    $mail->Username = email_userName;
    $mail->Password = pass;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = smtp_port; // Puerto SMTP

    // Configuración del remitente y destinatario
    $mail->setFrom(email_userName, "Krozz");
    $mail->addAddress($email, $username);

    // Configuración del asunto y cuerpo del correo
    $mail->isHTML(true);
    $mail->Subject = 'Codigo de verificacion de 2 pasos papu';
    $mail->Body  = "Hola $username, <br><br> Gracias por registrarte en nuestro sitio web. <br><br> Tu codigo de verificacion es: $code <br><br> Saludos, <br> Krozz";


    // Enviar el correo
    $mail->send();


} catch (Exception $e) {
    // Error: El correo no se pudo enviar
    echo "Al parecer hubo un error al enviar el correo, por favor intenta de nuevo $mail->ErrorInfo";
}

$sql = "INSERT INTO users (username, email, password, verificado, codigo) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->getConnection()->prepare($sql);

$stmt->bind_param("sssis", $username, $email, $password, $verificado, $code);

if ($stmt->execute()) {
    echo "<script>location.href='validar-codigo.php'</script>";
} else {
    echo "Registration failed.";
}

$stmt->close();
}
?>