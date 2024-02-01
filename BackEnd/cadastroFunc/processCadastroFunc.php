<?php
include_once "../conexao.php";
$db = new Conexao();
if (isset($_GET['solicitaCad'])) {
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $cpf = $_POST['cpf'];
    $logradouro = $_POST['logradouro'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $dtNasc = $_POST['dtNasc'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $dtRegistro = $_POST['dtRegistro'];
    $senha = $_POST['senha'];
    $confirmaSenha = $_POST['confirmaSenha'];
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
                    ':senha' => $senha,
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
                } elseif ($result->rowCount() > 0) {
                    header("Location: ../../Gerente/gerFuncionarios.php?SUCESS=1");
                    exit();
                }
            }
        } elseif ($result->rowCount() > 0) {
            header("Location: ../../Gerente/gerFuncionarios.php?ERROR=2");
            exit();
        }
    } elseif ($result->rowCount() > 0) {
        header("Location: ../../Gerente/gerFuncionarios.php?ERROR=1");
        exit();
    }
} elseif (!isset($_GET['solicitaCad'])) {
    header("Location: ../../Gerente/gerFuncionarios.php");
    exit();
}
