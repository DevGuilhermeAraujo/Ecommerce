<?php
include_once "../conexao.php";
$db = new Conexao();
if (isset($_POST['email']) and isset($_POST['senha'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $result = $db->executar("SELECT email, senha FROM users WHERE email = '$email' AND senha = 'senha'", true);
    if($result->rowCount() == 1){
        header("Location: ../sessao.php?email=$email&&loginSucess");
        exit();
    }elseif($result->rowCount() == 0){
        header("Location: ../../Cliente/homeCliente.php?loginFailed");
    }
}
