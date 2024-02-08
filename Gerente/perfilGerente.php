<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PerfilGerente</title>
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="gerente.css">
</head>
<body>

    <!--Painel com o perfil de gerente-->
   <div class="craxa">
        <img class="imgPerfil" src="../Imagens/Fundos/fundoPrincipal.jpg" alt="imagem de perfil">
        <div class="infoPerfil">
            <h2>Nome completo</h2>
            <p>CPF: <span>000.000.000-00</span></p>
            <p>Idade: <span>00</span></p>
            <p>Cargo: <span>Gerente</span></p>
            <p>Endereço: <span>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</span></p>
            <p>Email: <span> xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</span></p>
            <button>Editar</button>
        </div>
   </div>

   <!--Fundo para os modais-->
   <div style="display: none;" id="perfilGerente" class="fundoModal"></div>

    <!--Modal para modificar perfil-->
    <div id="modificarPerfil" class="modal">
        <img onclick="FecharModal()" class="fecharModal" src="../Imagens/Icones/Fechar.png" alt="icone fechar">
        <h2><img src="" alt=""> Modificar perfil <img src="" alt=""></h2>
    </div>

</body>
</html>