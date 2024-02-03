<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de produtos</title>
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="funcionario.css">
</head>
<body>

    <!--Formulário de cadastro de produtos-->
    <!--
        OBS:

        max de caracteres para o nome  do produto é: 22

        max de caracteres para a descrição é: 250
        
        max de caracteres para preço é: 10
        
        quando a checkBox NOVIDADE estiver marcada durante o caddastro, 
        o produto ir-a aparecer em uma tabela novidades por 30 dias
    -->
    <form class="cadProduto" action="../BackEnd/cadastros/processCadastroProd.php?solicitaCad" method="POST" enctype="multipart/form-data">
        <h2><img src="../Imagens/Icones/compra.png" alt="icone de compra"> Novo produto <img src="../Imagens/Icones/compra.png" alt="icone compra"></h2>
        <input type="text" placeholder="Nome do produto" name="nomeProd">
        <textarea cols="100%" rows="5" placeholder="Descrição do produto" name="descProd"></textarea>
        <input type="file" name="imgProd">
        <input type="text" placeholder="URL da imagem" name="urlImg">
        <input type="text" placeholder="Valor do produto" name="valorProd">
        <div class="comLeg">
            <label for="">Tipo</label>
            <select name="categoria">
                <option value="0">Geral</option>
            </select>
        </div>
        <div class="comLeg">
            <input type="checkbox" name="novidade" value="1">
            <label for="">Novidade</label>
        </div>
        <input style="background-color: #a3015a;color: white;padding: 3%;" type="submit" value="Cadastrar">
    </form>

    <script src="../index.js"></script>
</body>
</html>