<?php
include_once "../BackEnd/sessao.php";
$url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
redirectURL($url, 'indexFuncionarios.php');
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home funcionário</title>
</head>

<body>
    <h1><?= getNome() ?></h1>
    <h1><?= getIdUser() ?></h1>

</body>

</html>