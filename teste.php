<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../libs/PHPMailer/src/PHPMailer.php';
require '../../libs/PHPMailer/src/Exception.php';
require '../../libs/PHPMailer/src/SMTP.php';


// Criar uma instância do PHPMailer
$mail = new PHPMailer(true);

try {
    // Configuração do servidor SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.example.com';  // Substitua pelo servidor SMTP do seu provedor
    $mail->SMTPAuth   = true;
    $mail->Username   = 'seu_email@example.com'; // Seu e-mail
    $mail->Password   = 'sua_senha'; // Sua senha
    $mail->SMTPSecure = 'tls'; // tls ou ssl
    $mail->Port       = 587; // Porta do servidor SMTP

    // Configuração do e-mail
    $mail->setFrom('seu_email@example.com', 'Seu Nome');
    $mail->addAddress('destinatario@example.com', 'Nome do Destinatário');
    $mail->Subject = 'Assunto do E-mail';
    $mail->Body    = 'Conteúdo do E-mail';

    // Enviar o e-mail
    $mail->send();
    echo 'E-mail enviado com sucesso!';
} catch (Exception $e) {
    echo 'Erro ao enviar o e-mail: ', $mail->ErrorInfo;
}
