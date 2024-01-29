<?php
include_once "conexao.php";
session_start();
$db = new Conexao();
if (isset($_GET['loginSucess'])) {
    $email = $_GET['email'];
    $dados = $db->executar("SELECT id, first_name, last_name, email, employee FROM users WHERE email = '$email'");
}
class sessao{
    function obterNome($nome, $sobrenome){
        $nomeCompleto = $nome . ' ' . $sobrenome;
        return $nomeCompleto;
    }
}
