<?php
include_once "../conexao.php";
include_once "../sessao.php";
$db = new Conexao();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['imgProd']) && $_FILES['imgProd']['error'] === UPLOAD_ERR_OK) {
        $nomeProd = htmlspecialchars($_POST['nomeProd'], ENT_QUOTES, 'UTF-8');
        $descProd = htmlspecialchars($_POST['descProd'], ENT_QUOTES, 'UTF-8');
        $valorProd = htmlspecialchars($_POST['valorProd'], ENT_QUOTES, 'UTF-8');
        $categoria = htmlspecialchars($_POST['categoria'], ENT_QUOTES, 'UTF-8');
        $novidade = htmlspecialchars($_POST['novidade'], ENT_QUOTES, 'UTF-8');
        $sql = "INSERT INTO products(prod_name, prod_desc, prod_value, prod_category, prod_news, creator_user, change_user) VALUES(:nomeProd, :descProd, :valorProd, :categoria, :novidade, :creatorUser, :changeUser)";
        //Defina os parâmetros para a consulta
        $parametros = [
            ':nomeProd' => $nomeProd,
            ':descProd' => $descProd,
            ':valorProd' => $valorProd,
            ':categoria' => $categoria,
            ':novidade' => $novidade,
            ':creatorUser' => getIdUser(),
            ':changeUser' => getIdUser(),
        ];
        $result = $db->executar($sql, $parametros);
        if (isset($result)) {
            //Preparando o nome da imagem para enviar a hospedagem
            $nomeArquivo = $_FILES['imgProd']['name'];
            $infoArquivo = pathinfo($nomeArquivo);
            $extensaoArquivo = $infoArquivo['extension'];
            //Pegando o último id inserido na tabela produtos e atribuíndo ao nome da imagem
            $sql = "SELECT LAST_INSERT_ID() AS posicao_atual";
            $parametros = null;
            $idProd = $db->executar($sql, $parametros);
            $urlProd = $idProd[0][0] . '.' . $extensaoArquivo;
            $sql = "UPDATE products SET url_img = :urlImg";
            $parametros = [
                ':urlImg' => $urlProd,
                ];
            $db->executar($sql, $parametros);
            $caminhoDestino = '../../Imagens/Produtos/' . $urlProd;
            // Move o arquivo para o diretório desejado
            $result = move_uploaded_file($_FILES['imgProd']['tmp_name'], $caminhoDestino);
            if (!isset($result)) {
                $sql = "DELETE FROM products WHERE id = :idProd";
                $parametros = [
                    ':idProd' => $idProd,
                ];
                $db->executar($sql, $parametros);
                if (getPermission() == 'employee') {
                    header("Location: ../../Funcionarios/indexFuncionarios.php?ERROR=10");
                    exit();
                } elseif (getPermission() == 'manager') {
                    header("Location: ../../Gerente/indexGerente.php?ERROR=10");
                    exit();
                }
            } else {
                if (getPermission() == 'employee') {
                    header("Location: ../../Funcionarios/indexFuncionarios.php?SUCESS=2");
                    exit();
                } elseif (getPermission() == 'manager') {
                    header("Location: ../../Gerente/indexGerente.php?SUCESS=2");
                    exit();
                }
            }
        } else {
            if (getPermission() == 'employee') {
                header("Location: ../../Funcionarios/indexFuncionarios.php?ERROR=11");
                exit();
            } elseif (getPermission() == 'manager') {
                header("Location: ../../Gerente/indexGerente.php?ERROR=11");
                exit();
            }
        }
    } else {
        echo "Erro no upload do arquivo. Código de erro: " . $_FILES['imgProd']['error'];
    }
}
