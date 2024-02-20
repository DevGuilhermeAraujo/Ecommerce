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
    <form class="cadProduto" action="../BackEnd/cadastros/processCadastroProd.php" method="POST" onsubmit="return validateFormProduct()" enctype="multipart/form-data" novalidate>
        <h2><img src="../Imagens/Icones/compra.png" alt="icone de compra"> Novo produto <img src="../Imagens/Icones/compra.png" alt="icone compra"></h2>
        <input type="text" placeholder="Título do produto" name="nomeProd">
        <textarea cols="100%" rows="5" placeholder="Descrição do produto" name="descProd"></textarea>
        <input id="btnArq" type="file" name="imgProd" accept=".jpg, .jpeg, .png">
        <input type="text" placeholder="Valor do produto" name="valorProd">
        <div class="comLeg">
            <label for="">Categoria</label>
            <select name="categoria">
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
        </div>
        <div class="comLeg">
            <input type="checkbox" name="novidade" value="1">
            <label for="">Novidade</label>
        </div>
        <input style="background-color: #a3015a;color: white;padding: 1%;" type="submit" value="Cadastrar">
        <div class="msgN">
            <span id="cadastroProdError">
                <?php if (isset($cadastroProdError)) {
                    echo $cadastroProdError;
                } ?>
            </span>
        </div>
    </form>

    <script src="../index.js"></script>
</body>

</html>