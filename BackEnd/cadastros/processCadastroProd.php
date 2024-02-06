<?php
include_once "../conexao.php";
include_once "../sessao.php";
$db = new Conexao();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['imgProd']) && $_FILES['imgProd']['error'] === UPLOAD_ERR_OK) {
        $nomeProd = htmlspecialchars($_POST['nomeProd'], ENT_QUOTES, 'UTF-8');
        $descProd = htmlspecialchars($_POST['descProd'], ENT_QUOTES, 'UTF-8');
        $nomeArquivo = $_FILES['imgProd']['name'];
        $valorProd = htmlspecialchars($_POST['valorProd'], ENT_QUOTES, 'UTF-8');
        $categoria = htmlspecialchars($_POST['categoria'], ENT_QUOTES, 'UTF-8');
        $novidade = htmlspecialchars($_POST['novidade'], ENT_QUOTES, 'UTF-8');
        // Move o arquivo para o diretório desejado
        $caminhoDestino = '../../Imagens/Produtos/' . $nomeArquivo;
        if (move_uploaded_file($_FILES['imgProd']['tmp_name'], $caminhoDestino)) {
            $sql = "INSERT INTO products(prod_name, prod_desc, prod_value, prod_category, prod_news, url_img, creator_user, change_user) VALUES(:nomeProd, :descProd, :valorProd, :categoria, :novidade, :urlImg, :creatorUser, :changeUser)";
            //Defina os parâmetros para a consulta
            $parametros = [
                ':nomeProd' => $nomeProd,
                ':descProd' => $descProd,
                ':valorProd' => $valorProd,
                ':categoria' => $categoria,
                ':novidade' => $novidade,
                ':urlImg' => $nomeArquivo,
                ':creatorUser' => getIdUser(),
                ':changeUser' => getIdUser(),

            ];
            $result = $db->executar($sql, $parametros);
            if ($result) {
                header("Location: ../../Funcionarios/indexFuncionarios.php?SUCESS=1");
                exit();
            } else {
                header("Location: ../../Funcionarios/indexFuncionarios.php?ERROR=1");
                exit();
            }
        } else {
        }
    } else {
        echo "Erro no upload do arquivo. Código de erro: " . $_FILES['imgProd']['error'];
    }
}
