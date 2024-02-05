<?php 
    //Pode resceber um get "redirect" para uma url personalizada após deslogar, se omitido padrão é a tela de login.
    include_once "sessao.php";
    logout();
    if(!isset($_GET["redirect"]) || $_GET["redirect"] == "")
        header("Location: ../Cliente/homeCliente.php");
    else
        header("Location: ".$_GET["redirect"]);