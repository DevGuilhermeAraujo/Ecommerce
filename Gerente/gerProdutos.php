<?php
include_once "../BackEnd/sessao.php";
$db = getDb();
$url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
redirectURL($url, 'indexGerente.php');
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="gerente.css">
    <script src="../BackEnd/script.js"></script>
</head>

<body>
    <!--Cadastro de produtos-->
    <!--
            OBS:
            max de caracteres para o nome  do produto é: 22
            max de caracteres para a descrição é: 250
            max de caracteres para preço é: 10
            quando a checkBox NOVIDADE estiver marcada durante o caddastro, 
            o produto ir-a aparecer em uma tabela novidades por 30 dias
        -->
    <form id="productForm" class="basicForm" action="" method="POST" enctype="multipart/form-data" novalidate onsubmit="return submitForm('productForm')">
        <h2><img src="../Imagens/Icones/compra.png" alt="icone de compra"> Novo produto <img src="../Imagens/Icones/compra.png" alt="icone compra"></h2>
        <input type="text" id="nomeProd" name="nomeProd" placeholder="Nome do produto">
        <input type="file" id="imgProd" name="imgProd" accept=".jpg, .jpeg, .png">
        <textarea cols="100%" rows="5" id="descProd" name="descProd" placeholder="Descrição do produto"></textarea>
        <input type="text" id="valorProd" name="valorProd" placeholder="Valor do produto">
        <select id="categoria" name="categoria">
            <option value="">Categoria do produto</option>
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
        <div class="checkBox">
            <input type="checkbox" id="novidade" name="novidade" value="1">
            <label for="novidade">Novidade</label>
        </div>
        <input id="cadastrarProduto" type="submit" value="Cadastrar">
        <div class="msgN">
            <span id="resultMessage">
                <?php if (isset($cadastroProdError)) {
                    echo $cadastroProdError;
                } ?>
            </span>
        </div>
    </form>

    <!--Filtro de produtos-->
    <form class="filtroProdutos">
        <select class="tipoProduto" name="categoria">
            <option value="">Geral</option>
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
        <input class="nomeProduto" type="text" placeholder="Procura algo em específico ?">
        <input class="filtrarProduto" type="submit" value="Filtrar">
    </form>

    <!--Produtos em exposição-->
    <div id="exposicao" class="exposição">
        <?php
        $sql = "SELECT id, prod_name, prod_value, url_img FROM products";
        $parametros = null;
        $result = $db->executar($sql, $parametros, true);
        foreach ($result as $produtos) {
            $idProd = $produtos['id'];
        ?>
            <div class="produto">
                <img src="../Imagens/Produtos/<?= $produtos['url_img'] ?>" alt="exemplo img">
                <div class="informações">
                    <h2><?= $produtos['prod_name'] ?></h2><span>?</span>
                    <h3>R$<?= $produtos['prod_value'] ?></h3><i>Compre já</i>
                    <span>-</span><button class="comprar">Adicionar ao carrinho <b>(0)</b></button><span>+</span>
                </div>
            </div>
        <?php
        }
        ?>
    </div>

    <script src="../index.js"></script>
</body>

</html>