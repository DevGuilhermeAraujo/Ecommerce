<?php
include_once "../BackEnd/sessao.php";
include_once "../BackEnd/conexao.php";
$db = new Conexao();
$url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
redirectURL($url, 'indexGerente.php');
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PerfilGerente</title>
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="gerente.css">
</head>

<body>
   <div class="craxa">
        <img class="imgPerfil" src="../Imagens/Fundos/fundoPrincipal.jpg" alt="imagem de perfil">
        <div class="infoPerfil">
            <h2>Nome completo</h2>
            <p>Idade: <span>00</span></p>
            <p>Cargo: <span>Gerente</span></p>
            <p>Endereço: <span>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</span></p>
            <p>Email: <span><?=getEmail()?></span></p>
            <button>Editar</button>
        </div>
   </div>
</body>

</html>