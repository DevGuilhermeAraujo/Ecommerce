<?php
include_once "../BackEnd/sessao.php";
requiredLogin(PERMISSION_FUNCIONARIO);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IndexFuncionário</title>
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="funcionário.css">
</head>
<body>

    <!--Menu dos funcionários-->
    <div class="barra">
        <div class="menu">
            <h2>Acesso Funcionário</h2>
            <img src="../Imagens/Icones/rosa.png" alt="icone flor">
            <a href="../BackEnd/logout.php"><img src="../Imagens/Icones/sair.png" alt="icone sair"> Sair</a>
            <a href=""><img src="../Imagens/Icones/home.png" alt="icone home"> Home</a>
            <a target="funçõesFuncionário" href="funProdutos.php"><img src="../Imagens/Icones/carrinho.png" alt="icone carrinho"> Produtos</a>
            <a target="funçõesFuncionário" href=""><img src="../Imagens/Icones/comunicação.png" alt="icone comunicação"> Comunicação</a>
        </div>
    </div>

    <!--Area de trabalho dos funcionários-->
    <div class="ifm">
        <iframe name="funçõesFuncionário" src="homeFuncionario.php" frameborder="0"></iframe>
    </div>
    
    <div ></div>
</body>
</html>