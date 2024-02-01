<?php
include_once "../conexao.php";
$db = new Conexao();
$email = $_POST['email'];
$senha = $_POST['senha'];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../../Cliente/homeCliente.php?invalidLogin");
    exit();
}
if ($senha == "") {
    header("Location: ../../Cliente/homeCliente.php?invalidLogin");
    exit();
}

//Validar com o banco

if ($db->errorCode != 0) {
    //Houve um erro de conexão
    header("Location: ../../Cliente/homeCliente.php?ERROR=1");
    exit();
}

//Buscar usuário
/*$result = $db->executar("SELECT ra from usuarios;");
    $userValid = false;
    foreach($result as $c){
        //Valida usuário
        if($c[0] == $ra_id){
            $userValid = true;
            break;
        }
    }*/
//             $sql = "SELECT * FROM users WHERE cpf = :cpf";
//             $parametros = [
//                 ':cpf' => $cpf,
//             ];
//             $result = $db->executar($sql, $parametros, true);
//             if ($result->rowCount() == 0) {
$sql = "SELECT email from users WHERE email = :email";
$parametros = [
    ':email' => $email,
];
$result = $db->executar($sql, $parametros, true);
$userValid = $result->rowCount();
if (!$userValid) {
    header("Location: ../../Cliente/homeCliente.php?invalidLogin");
    exit();
}

//Valida senha
$sql = "SELECT passwordUser from users WHERE email = :email";
$parametros = [
    ':email' => $email,
];
$result = $db->executar($sql, $parametros, true);
//if(!password_verify($password, $result[0]['senha']) && $result[0][0] != $password){ // IMPORTANTE -> A segunda parte do '&&' (E) deve ser removida após a padronização da criptografia!
if (!password_verify($password, $result[0]['passwordUser'])) {
    header("Location: ../../Cliente/homeCliente.php?invalidLogin");
    exit();
}

//Concluir login na sessão e Indentificar tipo de usuário
include_once "../sessao.php";
$_SESSION[SESSION_USER_EMAIL] = $email;

$result = $db->executar("SELECT nome FROM usuarios WHERE ra = $ra_id;");
$_SESSION[SESSION_USERNAME] = $result[0][0];

$result = $db->executar("SELECT tipo FROM usuarios WHERE ra = $ra_id", true);
$permisson = 0;
if ($result->rowCount() == 3) {
    $permisson = PERMISSION_CLIENTE;
} else {
    $result = $result->fetchAll();
    $permisson = $result[0][0];
}
$_SESSION[SESSION_USER_IDPERMISSION] = $permisson;


//Redirecionar
redirectByPermission($permisson);
