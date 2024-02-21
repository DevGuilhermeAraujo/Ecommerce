<?php
include_once "../sessao.php";

$db = getDb();

$token = $_POST['codConfirm'];
$sql = "SELECT * FROM users WHERE email = :email AND token = :token";
$parametros = [
    ':email' => getEmail(),
    ':token' => $token,
];
$result = $db->executar($sql, $parametros, true);
if (empty($result->fetch())) {
    logout();
    header("Location: ../../index.php");
    exit();
} else {
    $sql = "UPDATE users SET confirmed = :confirmed WHERE email = :email";
    $parametros = [
        ':confirmed' => 1,
        ':email' => getEmail(),
    ];
    $result = $db->executar($sql, $parametros, true);
    if ($result == false) {
        logout();
        header("Location: ../../index.php");
        exit();
    } else {
        redirectByPermission($_SESSION[SESSION_USER_IDPERMISSION]);
    }
}
// Agora você pode usar $token e $email conforme necessário
