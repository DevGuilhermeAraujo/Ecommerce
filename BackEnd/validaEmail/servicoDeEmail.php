<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require_once '../conexao.php';
require_once '../sessao.php';

global $db;
$db = new Conexao();

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


function validEmail()
{
    global $db;
    // Gere um token único
    $token = mt_rand(100000, 999999);
    // Calcule o tempo de expiração (por exemplo, 24 horas a partir do momento atual)
    // $tempoExpiracao = time() + (24 * 60 * 60);

    // Armazene o token e o tempo de expiração no banco de dados associado ao usuário
    $sql = "UPDATE users SET token = :token WHERE id = :id";
    $parametros = [
        ':token' => $token,
        // ':token_expiration' => $tempoExpiracao,
        ':id' => getIdUser(),
    ];
    $db->executar($sql, $parametros);
    // Envie o e-mail de confirmação
    $assunto = "Confirmação de Registro - Ecommerce Beleza Rosa";
    $mensagem = "Olá " . getNome() . ", \n
    Obrigado por se cadastrar no Ecommerce Beleza Rosa! Para concluir o processo de registro, precisamos verificar seu endereço de e-mail. \n
    Clique no link abaixo para confirmar seu e-mail: \n
    $token \n
    Se você não se registrou no Ecommerce Beleza Rosa, ignore este e-mail. \n
    Atenciosamente, \n
    Equipe Ecommerce Beleza Rosa \n";
    conectEmail(getEmail(), getNome(), $assunto, $mensagem);
}
