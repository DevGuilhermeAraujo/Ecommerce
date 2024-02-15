<?php
include_once "../BackEnd/sessao.php";
requiredLogin(PERMISSION_GERENTE);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IndexGerente</title>
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="gerente.css">
</head>

<body>

    <!--Menu para menos de 1005px-->
    <div class="barra2">
        <button onclick="Trocar(btnMenu,menu2)" id="btnMenu"><img src="../Imagens/Icones/menu.png" alt="icone menu">Menu</button>
        <div style="display: none;" id="menu2" class="menu2">
            <button id="fecharMenu" onclick="Trocar(menu2,btnMenu)"><img src="../Imagens/Icones/Fechar2.png" alt="icone fechar"></button>
            <a href="../BackEnd/logout.php"><img src="../Imagens/Icones/sair.png" alt="icone sair"> Sair</a>
            <a href=""><img src="../Imagens/Icones/home.png" alt="icone home"> Home</a>
            <a target="funçõesGerente" href="gerFuncionarios.php"><img src="../Imagens/Icones/equipe.png" alt="icone equipe"> Funcionários</a>
            <a target="funçõesGerente" href="gerProdutos.php"><img src="../Imagens/Icones/carrinho.png" alt="icone carrinho"> Produtos</a>
            <a target="funçõesGerente" href=""><img src="../Imagens/Icones/comunicação.png" alt="icone comunicação"> Comunicação</a>
        </div>
    </div>

    <!--Menu do gerente-->
    <div class="barra">
        <div class="menu">
            <img src="../Imagens/Icones/rosa.png" alt="icone flor">
            <a href="../BackEnd/logout.php"><img src="../Imagens/Icones/sair.png" alt="icone sair"> Sair</a>
            <a href=""><img src="../Imagens/Icones/home.png" alt="icone home"> Home</a>
            <a target="funçõesGerente" href="gerFuncionarios.php"><img src="../Imagens/Icones/equipe.png" alt="icone equipe"> Funcionários</a>
            <a target="funçõesGerente" href="gerProdutos.php"><img src="../Imagens/Icones/carrinho.png" alt="icone carrinho"> Produtos</a>
            <a target="funçõesGerente" href=""><img src="../Imagens/Icones/comunicação.png" alt="icone comunicação"> Comunicação</a>
            <a target="funçõesGerente" href="perfilGerente.php"><img src="../Imagens/Icones/perfil.png" alt="icone perfil"> Perfil</a>
        </div>
    </div>

    <!--Area de trabalho do gerente-->
    <div class="ifm">
        <iframe name="funçõesGerente" src="homeGerente.php" frameborder="0"></iframe>
    </div>

    <?php
    //Menssagem de falha no Banco
    if (isset($_GET["ERROR"]) && $_GET["ERROR"] == 1) {
        msg(MSG_NEGATIVE_BG, "Falha ao cadastrar usuario. Este CPF já está sendo utilizado");
    }

    //Menssagem de falha no Banco 
    if (isset($_GET["ERROR"]) && $_GET["ERROR"] == 2) {
        msg(MSG_NEGATIVE_BG, "Falha ao cadastrar usuario. Este e-mail já está sendo utilizado");
    }

    if (isset($_GET["ERROR"]) && $_GET["ERROR"] == 3) {
        msg(MSG_NEGATIVE_BG, "Falha ao cadastrar usuario. Tente novamente");
    }

    if (isset($_GET["SUCESS"]) && $_GET["SUCESS"] == 1) {
        msg(MSG_POSITIVE_BG, "Usuário cadastrado com sucesso");
    }

    //Menssagem de erro geral
    if (isset($_GET["ERROR"]) && $_GET["ERROR"] == null) {
        msg(MSG_NEGATIVE_BG, "Erro desconhecido, por favor entre em contato com o adminstrador do sistema.");
    }
    ?>

    <script src="../index.js"></script>
</body>

</html>