<?php
include_once "conexao.php";
session_start();
//Constantes de ambiente
//Legado - Remover posteriormente
const SESSION_USER_ID = "UserId";
const SESSION_USERNAME = "UserName";
const SESSION_CPF = "UserCpf";
$db = new Conexao();
if (isset($_GET['loginSucess'])) {
    $email = $_GET['email'];
    $dados = $db->executar("SELECT id, first_name, last_name, email, employee FROM users WHERE email = '$email'");
}
function getName()
{
    return getName();
}
