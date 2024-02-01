<?php
include_once "conexao.php";
session_start();
//Constantes de ambiente
//Legado - Remover posteriormente

const SESSION_CPF = "UserCpf";
$db = new Conexao();
if (isset($_GET['loginSucess'])) {
    $email = $_GET['email'];
    $dados = $db->executar("SELECT id, first_name, last_name, email, employee FROM users WHERE email = '$email'");
}
function getName()
{
    return getName();
}




//Constantes de ambiente
const SESSION_USER_ID = "UserId";
const SESSION_USERNAME = "UserName";
const SESSION_USER_IDPERMISSION = "UserIdPermission";

const PERMISSION_GERENTE = 1;
const PERMISSION_PROFESSOR = 2;
const PERMISSION_ALUNO = 3;

//Pegar diretamente do banco:
//function PERMISSION_GERENTE(){include_once "conexao.php"; return (new Conexao())->executar("SELECT cod FROM tipos WHERE nomeTipo='Gerente';")[0][0];}
//function PERMISSION_PROFESSOR(){include_once "conexao.php"; return (new Conexao())->executar("SELECT cod FROM tipos WHERE nomeTipo='Aluno';")[0][0];}
//function PERMISSION_ALUNO(){include_once "conexao.php"; return (new Conexao())->executar("SELECT cod FROM tipos WHERE nomeTipo='Aluno';")[0][0];}


//Funções para o Front-End
function Logued(?Int $permission = null)
{
    if (isset($_SESSION[SESSION_USER_ID]) && $_SESSION[SESSION_USER_ID] != "") {
        if ($permission != null)
            if ($_SESSION[SESSION_USER_IDPERMISSION] != $permission)
                return false;
        if (isset($_SESSION[SESSION_USERNAME]) || $_SESSION[SESSION_USERNAME] != "")
            if (isset($_SESSION[SESSION_USER_IDPERMISSION]) || $_SESSION[SESSION_USER_IDPERMISSION] != "")
                return true;
    }
    return false;
}

function requiredLogin(?Int $permission = null, ?String $URL = null)
{
    if (!Logued($permission)) {
        if (is_null($URL)) {
            header("Location: ../Login/pagLogin.php");
            exit();
        } else {
            header("Location: " . $URL);
            exit();
        }
    }
}

function logout()
{
    //Sair do usuario (deslogar)
    unset($_SESSION[SESSION_USER_RA_ID]);
    unset($_SESSION[SESSION_USERNAME]);
    unset($_SESSION[SESSION_USER_IDPERMISSION]);
    unset($_SESSION);
    session_destroy();
}

function redirectByPermission($_permission)
{
    if ($_permission == PERMISSION_ALUNO) {
        //header("Location: ")
        header("Location: ../Alunos/indexAluno.php");
        exit();
    }
    if ($_permission == PERMISSION_PROFESSOR) {
        header("Location: ../Professores/indexProfessores.php");
        exit();
    }
    if ($_permission == PERMISSION_GERENTE) {
        header("Location: ../Gerente/indexGerente.php");
        exit();
    }
    //Se algo der errado
    //Limpar sessão e reportar erro
    error_log("Falha ao tentar fazer login, Cógido = Erro processLogin, return 2, Erro: Não foi possivel determinar o tipo do usuário; Falha ocorreu na tentativa do usuário: id=" . $_SESSION[SESSION_USER_RA_ID] . ", Falha de permissão retornado=$_permission", 3, "C:\PhpSiteEscolaErrorsLog.log");
    logout();
    header("Location: ../Login/pagLogin.php?ERROR=2");
}


function getIdRa()
{
    return $_SESSION[SESSION_USER_RA_ID];
}

function getNome()
{
    return $_SESSION[SESSION_USERNAME];
}

function getPermission()
{
    //return $_SESSION[SESSION_USER_IDPERMISSION];
    try{
        include_once "conexao.php";
        $db = new Conexao();
        return $db->executar("SELECT tipo FROM usuarios WHERE ra = '".$_SESSION[SESSION_USER_RA_ID]."'")[0][0];
    }catch(Exception $e){
        logout();
        header("Location: ../Login/pagLogin.php?ERROR=3");
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

    if(!$hideTimer == 0){
        //Se a menssagem vai desaparecer
        //Tenta inserir o javascript caso não esteja na pagina (melhorar depois)
        if($importJsUri == null){
            //Tenta importar de um caminho padrão
            echo '<script src="../BackEnd/script.js"></script>';
        }else{
            //Importa de um caminho determinado
            echo '<script src="'.$importJsUri.'"></script>';
        }
        //Chamar o metodo javascript para interação no lado cliente
        echo "<script>deleteMsg($hideTimer,$id);</script>";
    }
}

function redirectPOST(string $url, string $values, ?string $importJsUri = "../BackEnd/script.js"){
    echo "<script src='$importJsUri'></script>";
    //Chamar o metodo javascript para interação no lado cliente
    echo "<script>redirectPOSTAjax('$url', '$values');</script>";
}