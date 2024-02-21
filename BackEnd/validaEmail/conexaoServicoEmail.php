<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Criar uma instância do PHPMailer

function conectEmail($email, $nome, $assunto, $conteudo)
{
    $mail = new PHPMailer(true);
    try {
        // Configuração do servidor SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';  // Substitua pelo servidor SMTP do seu provedor
        $mail->SMTPAuth   = true;
        $mail->Username   = 'devshostinger@gmail.com'; // Seu e-mail
        $mail->Password   = 'oqrn cytd tlwi kvka'; // Sua senha
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // tls ou ssl
        $mail->Port = 465; // Porta do servidor SMTP

        // Configuração do e-mail
        $mail->setFrom('devshostinger@gmail.com', 'Beleza Rosa');
        $mail->addAddress($email, $nome);
        $mail->Subject = $assunto;
        $mail->Body    = $conteudo;

        // Enviar o e-mail
        $mail->send();
        header("Location:../../Cliente/homeCliente.php?SUCESS=11");
    } catch (Exception $e) {
        echo 'Erro ao enviar o e-mail: ', $mail->ErrorInfo;
    }
}
