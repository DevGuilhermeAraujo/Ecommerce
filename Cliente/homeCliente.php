<?php
include_once "../BackEnd/sessao.php";
include_once "../BackEnd/conexao.php";
$db = new Conexao();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomeCliente</title>
    <link rel="stylesheet" href="cliente.css">
    <link rel="stylesheet" href="../index.css">
</head>

<body>
    <!--Painel superior-->
    <div id="Top">
        <h1>Olá, seja bem vindo(a)</h1>
    </div>

    <!--Botão de menu (apenas para celulares-->
    <div class="menuResponsivo">
        <button onclick="Trocar(btnMenu,nav)" id="btnMenu" class="btnMenu"><img src="../Imagens/Icones/menu.png" alt="icone menu"></button>
        <h2><img src="../Imagens/Icones/flor.png" alt="icone flor"> Espaço Beleza rosa <img src="../Imagens/Icones/flor.png" alt="icone flor"></h2>
    </div>

    <!--Nav com os links das pags do cliente-->
    <div id="nav" class="nav">
        <img onclick="Trocar(nav,btnMenu)" class="fecharMenuResponsivo" src="../Imagens/Icones/Fechar2.png" alt="icone fechar">
        <img class="florResponsiva" src="../Imagens/Icones/rosa.png" alt="icone flor">
        <a href=""><img src="../Imagens/Icones/novidades.png" alt="icone novidades"> Novidades</a>
        <a href=""><img src="../Imagens/Icones/carrinho.png" alt="icone carrinho"> Carrinho</a>
        <a href=""><img src="../Imagens/Icones/comunicação.png" alt="icone comunicação">Comunicação</a>
        <button onclick="AbrirModal(HomeCliente,login)" href=""><img src="../Imagens/Icones/entrar.png" alt="icone entrar"> Login</button>
    </div>

    <!--Filtro de produtos-->
    <form id="filtro">
        <select name="categoria" id="tipo">
            <option value="1">Geral</option>
            <?php
            $sql = "SELECT id, description_cat FROM category";
            $parametros = null;
            $result = $db->executar($sql, $parametros);
            foreach ($result as $categorias) {
                $idCat = $categorias['id'];
                $descCat = $categorias['description_cat'];
                echo "<option value='$idCat'>$descCat</option>";
            }
            ?>
        </select>
        <input id="pesquisa" type="text" placeholder="Procura algo em específico ?">
        <input id="filtrar" type="submit" value="Filtrar">
    </form>

    <!--Paineis dos produtos-->
    <!--
        Organização para o retorno dos produtos: 

        <div class="produto">
            <h3> NOME DO PRODUTO </h3>
            <img src=" URL DA IMAGEM " alt=" DESCRIÇÃO DA IMG">
            <p> DESCRIÇÃO DO PRODUTO</p>
            <h4> PREÇO DO PRODUTO</h4>
            <div class="comprar">
                <span>-</span><button>Adicionar ao carrinho ( QUANTIDADE )</button><span>+</span>
            </div>
        </div>

    -->
    <div class="prateleira">
        <?php
        $sql = "SELECT id, prod_name, prod_desc, prod_value, url_img FROM products;";
        $result = $db->executar($sql);
        foreach ($result as $produtos) {
            echo "<div class='produto'>";
            $nomeProd = $produtos['prod_name'];
            $descProd = $produtos['prod_desc'];
            $valueProd = $produtos['prod_value'];
            $urlImg = $produtos['url_img'];
            echo "<h3>$nomeProd</h3>";
            echo "<img src='../Imagens/Produtos/$urlImg' alt='icone exemplo'>";
            echo "<h4>$valueProd</h4>";
            echo "<div class='comprar'> <span>-</span><button>Adicionar ao carrinho (0)</button><span>+</span></div>";
            echo "</div>";
        }
        ?>
    </div>

    <!--Fundo para os modals-->
    <div style="display: none;" id="HomeCliente" class="fundoModal"></div>

    <!--Modal para login-->
    <form style="display: none;" id="login" class="modal" action="../BackEnd/login/validaLogin.php" method="POST">
        <img id="fecharLogin" onclick="FecharModal(HomeCliente,login)" class="fecharModal" src="../Imagens/Icones/Fechar.png" alt="icone fechar">
        <h2><img src="../Imagens/Icones/flor.png" alt="icone flor"> Espaço beleza rosa <img src="../Imagens/Icones/flor.png" alt="icone flor"></h2>
        <img id="loginImg" src="../Imagens/Icones/usuario.png" alt="icone usuario">
        <p>Faça login em sua conta</p>
        <input type="email" placeholder="E-mail" name="email">
        <input type="password" placeholder="Senha" name="senha">
        <input id="logar" type="submit" value="Login">
    </form>
    <?php
    if (isset($_GET['SUCESS']) && ($_GET['SUCESS'] == 11)) {
        echo '<script>';
        echo 'window.onload = function() {';
        echo '    AbrirModal(HomeCliente, tokenEmail);';
        echo '};';
        echo '</script>';
    ?>
        <form style="display: none;" id="tokenEmail" class="modal" action="../BackEnd/validaEmail/validaEmail.php" method="POST">
            <img id="fecharLogin" onclick="FecharModal(HomeCliente,tokenEmail)" class="fecharModal" src="../Imagens/Icones/Fechar.png" alt="icone fechar">
            <input type="codConfirm" placeholder="Código de confirmação" name="codConfirm">
            <input id="logar" type="submit" value="Login">
        </form>
    <?php
    }
    ?>

    <script src="../index.js"></script>
</body>

</html>