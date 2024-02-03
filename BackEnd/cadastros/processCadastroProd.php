<?php
include_once "../conexao.php";
$db = new Conexao();
if (isset($_GET['solicitaCad'])) {
    if ($_FILES['imgProd']['error'] == UPLOAD_ERR_OK) {
        $nomeProd = htmlspecialchars($_POST['nomeProd'], ENT_QUOTES, 'UTF-8');
        $descProd = htmlspecialchars($_POST['descProd'], ENT_QUOTES, 'UTF-8');
        $imgProd = $_FILES['imgProd']['name'];
        $urlImg = htmlspecialchars($_POST['urlImg'], ENT_QUOTES, 'UTF-8');
        $valorProd = htmlspecialchars($_POST['valorProd'], ENT_QUOTES, 'UTF-8');
        $categoria = htmlspecialchars($_POST['categoria'], ENT_QUOTES, 'UTF-8');
        $novidade = htmlspecialchars($_POST['novidade'], ENT_QUOTES, 'UTF-8');

        // Move o arquivo para o diretório desejado
        $caminhoDestino = 'caminho/para/seu/diretorio/' . $nomeArquivo;
        move_uploaded_file($caminhoTemporario, $caminhoDestino);
    } else {
        echo "Erro no upload do arquivo. Código de erro: " . $_FILES['imgProd']['error'];
    }





    $sql = "SELECT * FROM users WHERE cpf = :cpf";
    $parametros = [
        ':cpf' => $cpf,
    ];
    $result = $db->executar($sql, $parametros, true);
    if ($result->rowCount() == 0) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $parametros = [
            ':email' => $email,
        ];
        $result = $db->executar($sql, $parametros, true);
        if ($result->rowCount() == 0) {
            if ($senha === $confirmaSenha) {
                $senhacriptografada = password_hash($senha, PASSWORD_DEFAULT);
                $sql = "INSERT INTO users(first_name, last_name, cpf, public_place, residenceNumber, neighborhood, date_Of_Birth, registration_Date, phone, email, passwordUser, employee, active) VALUES(:nome, :sobrenome, :cpf, :logradouro, :numero, :bairro, :dtNasc, :dtRegistro, :telefone, :email, :senha, :funcionario, :ativo)";
                // Defina os parâmetros para a consulta
                $parametros = [
                    ':nome' => $nome,
                    ':sobrenome' => $sobrenome,
                    ':cpf' => $cpf,
                    ':logradouro' => $logradouro,
                    ':numero' => $numero,
                    ':bairro' => $bairro,
                    ':dtNasc' => $dtNasc,
                    ':dtRegistro' => $dtRegistro,
                    ':telefone' => $telefone,
                    ':email' => $email,
                    ':senha' => $senhacriptografada,
                    ':funcionario' => 'S',
                    ':ativo' => 'S',
                ];
                $db->executar($sql, $parametros);
                $sql = "SELECT * FROM users WHERE cpf = :cpf";
                $parametros = [
                    ':cpf' => $cpf,
                ];
                $result = $db->executar($sql, $parametros, true);
                if ($result->rowCount() == 0) {
                    header("Location: ../../Gerente/gerFuncionarios.php?ERROR=3");
                    exit();
                } else {
                    header("Location: ../../Gerente/gerFuncionarios.php?SUCESS=1");
                    exit();
                }
            }
        } else {
            header("Location: ../../Gerente/gerFuncionarios.php?ERROR=2");
            exit();
        }
    } else {
        header("Location: ../../Gerente/gerFuncionarios.php?ERROR=1");
        exit();
    }
} elseif (!isset($_GET['solicitaCad'])) {
    header("Location: ../../Gerente/gerFuncionarios.php");
    exit();
}
