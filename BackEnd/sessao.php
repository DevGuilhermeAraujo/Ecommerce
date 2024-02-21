<?php
include_once "conexao.php";
session_start();

//Constantes de ambiente
const SESSION_USER_EMAIL = "Useremail";
const SESSION_USERNAME = "UserName";
const SESSION_USER_IDPERMISSION = "UserIdPermission";
const SESSION_USER_ID = "UserId";

const PERMISSION_GERENTE = 'manager';
const PERMISSION_FUNCIONARIO = 'employee';
const PERMISSION_CLIENTE = 'client';

//Pegar diretamente do banco:
//function PERMISSION_GERENTE(){include_once "conexao.php"; return (new Conexao())->executar("SELECT cod FROM tipos WHERE nomeTipo='Gerente';")[0][0];}
//function PERMISSION_PROFESSOR(){include_once "conexao.php"; return (new Conexao())->executar("SELECT cod FROM tipos WHERE nomeTipo='Aluno';")[0][0];}
//function PERMISSION_ALUNO(){include_once "conexao.php"; return (new Conexao())->executar("SELECT cod FROM tipos WHERE nomeTipo='Aluno';")[0][0];}


//Funções para o Front-End
function Logued(?String $permission = null)
{
    if (isset($_SESSION[SESSION_USER_EMAIL]) && $_SESSION[SESSION_USER_EMAIL] != "") {
        if ($permission != null)
            if ($_SESSION[SESSION_USER_IDPERMISSION] != $permission)
                return false;
        if (isset($_SESSION[SESSION_USERNAME]) || $_SESSION[SESSION_USERNAME] != "")
            if (isset($_SESSION[SESSION_USER_IDPERMISSION]) || $_SESSION[SESSION_USER_IDPERMISSION] != "")
                return true;
    }
    return false;
}

function requiredLogin(?String $permission = null, ?String $URL = null)
{
    if (!Logued($permission)) {
        if (is_null($URL)) {
            header("Location: ../Cliente/homeCliente.php");
            exit();
        } else {
            header("Location: " . $URL);
            exit();
        }
    }
}

function redirectURL($urlfilha, $urlpai)
{
    // Verifica se o referenciador é da página principal
    if (strpos($urlfilha, $urlpai) === false) {
        // Redireciona para a página principal ou exibe uma mensagem de erro
        header("Location: $urlpai ");
        exit;
    }
}

function logout()
{
    //Sair do usuario (deslogar)
    unset($_SESSION[SESSION_USER_EMAIL]);
    unset($_SESSION[SESSION_USERNAME]);
    unset($_SESSION[SESSION_USER_IDPERMISSION]);
    unset($_SESSION[SESSION_USER_ID]);
    unset($_SESSION);
    session_destroy();
}

function redirectByPermission($_permission)
{
    if ($_permission == PERMISSION_CLIENTE) {
        //header("Location: ")
        header("Location: ../Cliente/homeCliente.php");
        exit();
    }
    if ($_permission == PERMISSION_FUNCIONARIO) {
        header("Location: ../../Funcionarios/indexFuncionarios.php");
        exit();
    }
    if ($_permission == PERMISSION_GERENTE) {
        header("Location: ../../Gerente/indexGerente.php");
        exit();
    }

    //Se algo der errado
    //Limpar sessão e reportar erro
    // error_log("Falha ao tentar fazer login, Cógido = Erro processLogin, return 2, Erro: Não foi possivel determinar o tipo do usuário; Falha ocorreu na tentativa do usuário: id=" . $_SESSION[SESSION_USER_EMAIL] . ", Falha de permissão retornado=$_permission", 3, "C:\PhpSiteEscolaErrorsLog.log");
    logout();
    header("Location: ../Cliente/homeCliente.php?ERROR=2");
}



function getEmail()
{
    return $_SESSION[SESSION_USER_EMAIL];
}
function getIdade()
{
    $db = new Conexao();
    $sql = "SELECT YEAR(CURDATE()) - YEAR(date_Of_Birth) - (RIGHT(CURDATE(), 5) < RIGHT(date_Of_Birth, 5)) AS idade FROM users WHERE email = :email;";
    $parametros = [
        ':email' => getEmail(),
    ];
    $result = $db->executar($sql, $parametros);
    return $result[0][0];
}
function getNome()
{
    return $_SESSION[SESSION_USERNAME];
}

function getIdUser()
{
    return $_SESSION[SESSION_USER_ID];
}

/** 
* @return Conexao
*/
function getDb()
{
   return new Conexao();
}

/**
 * return servicoEmail
 */

 function getServEmail(){
    return include_once "validaEmail/servicoDeEmail.php";
 }

function getPermission()
{
    //return $_SESSION[SESSION_USER_IDPERMISSION];
    try {
        include_once "conexao.php";
        $db = new Conexao();
        return $db->executar("SELECT tipo FROM view_client_user_combined WHERE email = '" . $_SESSION[SESSION_USER_EMAIL] . "'")[0][0];
    } catch (Exception $e) {
        logout();
        header("Location: ../Cliente/homeCliente.php?ERROR=3");
        exit();
    }
}

//Menssagem Pop-up com/sem background
const MSG_POSITIVE = 1;
const MSG_NEGATIVE = 2;
const MSG_POSITIVE_BG = 3;
const MSG_NEGATIVE_BG = 4;

function msg(int $type, string $message, ?string $class = "", ?string $style = "", ?string $id = "", ?int $hideTimer = 0, ?string $importJsUri = null)
{
    switch ($type) {
        case 1:
            //Menssangem positiva
            echo '<span id="' . $id . '" class="msgV ' . $class . '" style="' . $style . '">' . $message . '</span>';
            break;
        case 2:
            //Menssagem negativa
            echo '<span id="' . $id . '" class="msgN ' . $class . '" style="' . $style . '">' . $message . '</span>';
            break;
        case 3:
            //Menssagem positiva com background
            echo '<span id="' . $id . '" class="msgV-bg ' . $class . '" style="' . $style . '">' . $message . '</span>';
            break;
        case 4:
            //Menssagem negativa com background
            echo '<span id="' . $id . '" class="msgN-bg ' . $class . '" style="' . $style . '">' . $message . '</span>';
            break;
        default:
            throw new Exception('Entrada invalida na função msg().');
    }

    if (!$hideTimer == 0) {
        //Se a menssagem vai desaparecer
        //Tenta inserir o javascript caso não esteja na pagina (melhorar depois)
        if ($importJsUri == null) {
            //Tenta importar de um caminho padrão
            echo '<script src="../BackEnd/script.js"></script>';
        } else {
            //Importa de um caminho determinado
            echo '<script src="' . $importJsUri . '"></script>';
        }
        //Chamar o metodo javascript para interação no lado cliente
        echo "<script>deleteMsg($hideTimer,$id);</script>";
    }
}

function redirectPOST(string $url, string $values, ?string $importJsUri = "../BackEnd/script.js")
{
    echo "<script src='$importJsUri'></script>";
    //Chamar o metodo javascript para interação no lado cliente
    echo "<script>redirectPOSTAjax('$url', '$values');</script>";
}


function criptografiaPassword()
{
    $db = new Conexao();
    $result = $db->executar("SELECT id, passwordUser FROM users WHERE LENGTH(passwordUser) < 60");
    foreach ($result as $user) {
        $senhacriptografada = password_hash($user['passwordUser'], PASSWORD_DEFAULT);
        $db->executar("UPDATE users SET passwordUser='$senhacriptografada' WHERE id=" . $user['id']);
    }
}

function validarEmail(int $id)
{
    $db = new Conexao();
    $sql = ('SELECT * FROM users WHERE id = :id AND confirmed IS NULL');
    $parametros = [
        ':id' => $id,
    ];
    $result = $db->executar($sql, $parametros, true);
    if (empty($result->fetch())) {
        return true;
    } else {
        return false;
    }
}

