<?php
include_once "../conexao.php";
$db = new Conexao();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = htmlspecialchars($_POST['nome'], ENT_QUOTES, 'UTF-8');
    $sobrenome = htmlspecialchars($_POST['sobrenome'], ENT_QUOTES, 'UTF-8');
    $cpf = htmlspecialchars($_POST['cpf'], ENT_QUOTES, 'UTF-8');
    $logradouro = htmlspecialchars($_POST['logradouro'], ENT_QUOTES, 'UTF-8');
    $numero = htmlspecialchars($_POST['numero'], ENT_QUOTES, 'UTF-8');
    $bairro = htmlspecialchars($_POST['bairro'], ENT_QUOTES, 'UTF-8');
    $telefone = htmlspecialchars($_POST['telefone'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $departamento = htmlspecialchars($_POST['departamento'], ENT_QUOTES, 'UTF-8');
    $senha = htmlspecialchars($_POST['senha'], ENT_QUOTES, 'UTF-8');
    $confirmaSenha = htmlspecialchars($_POST['confirmaSenha'], ENT_QUOTES, 'UTF-8');
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
                $sql = "INSERT INTO users(first_name, last_name, cpf, public_place, residenceNumber, neighborhood, date_Of_Birth, phone, email, departments, passwordUser, active) VALUES(:nome, :sobrenome, :cpf, :logradouro, :numero, :bairro, :dtNasc, :telefone, :email, :departamento, :senha, :ativo)";
                // Defina os parâmetros para a consulta
                $parametros = [
                    ':nome' => $nome,
                    ':sobrenome' => $sobrenome,
                    ':cpf' => $cpf,
                    ':logradouro' => $logradouro,
                    ':numero' => $numero,
                    ':bairro' => $bairro,
                    ':telefone' => $telefone,
                    ':email' => $email,
                    ':departamento' => $departamento,
                    ':senha' => $senhacriptografada,
                    ':ativo' => '1',
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
