<?php
include_once "../BackEnd/sessao.php";
//Pagina padrão
criptografiaPassword();
//Redirecionameto para a tela de login
header("Location: Cliente/homeCliente.php");
exit;
