<?php
include_once "../BackEnd/sessao.php";
include_once "../BackEnd/conexao.php";
$db = new Conexao();
$url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
redirectURL($url, 'indexGerente.php');
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>editar funcionarios</title>
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="gerente.css">
    <script src="../BackEnd/script.js"></script>
</head>

<body>

    <!--Formulário de cadastro de novos funcionários + botão de analisar currículos-->
    <!--
            OBS: 

            Max de caracteres para nome: 20

            Max de caracteres para sobrenome: 20

            Max de caracteres para CPF: 11

            A nova senha deve conter no mínimo 8 caaracteres,
            pelo menos 1 caractere especial e pelo menos 1 número.

            O campo CONFIRME A NOVA SENHA, deve conter valor igual
            ao campo NOVA SENHA
        -->
        <form class="basicForm" action="../BackEnd/cadastros/processCadastroFunc.php" method="POST" onsubmit="return validateForm()" novalidate>
            <h2><img src="../Imagens/Icones/pessoaMais.png" alt="icone adicionar pessoa"> Novo funcionário <img src="../Imagens/Icones/pessoaMais.png" alt="icone adicionar pessoa"></h2>
            <button onclick="AbrirModal(GerFuncionarios,analisarCurriculos)">Analisar currículos</button>
            <input type="text" id="nome" placeholder="Nome" name="nome">
            <input type="text" id="sobrenome" placeholder="Sobrenome" name="sobrenome">
            <input type="text" id="cpf" placeholder="CPF" name="cpf" oninput="maskCPF()">
            <input type="email" id="email" placeholder="Email" name="email">
            <input type="text" id="logradouro" placeholder="Logradouro" name="logradouro">
            <input type="text" id="numero" placeholder="Número" name="numero">
            <input type="text" id="bairro" placeholder="Bairro" name="bairro">
            <input type="text" id="telefone" placeholder="Telefone" name="telefone" oninput="maskPhone()">
            <select name="departamento">
                <option value="">Departamento</option>
                <?php
                $sql = "SELECT id, description_dep FROM departments";
                $parametros = null;
                $result = $db->executar($sql, $parametros);
                foreach ($result as $departamentos) {
                    $idDep = $departamentos['id'];
                    $descDep = $departamentos['description_dep'];
                    echo "<option value='$idDep'>$descDep</option>";
                }
                ?>
            </select>
            <input type="password" id="senha" placeholder="Nova senha" name="senha">
            <input type="password" id="confirmaSenha" placeholder="Confirme a nova senha" name="confirmaSenha">
            <input id="cadastrarFuncionário" type="submit" value="Cadastrar">
            <div class="msgN">
                <span id="cadastroError">
                    <?php if (isset($cadastroError)) {
                        echo $cadastroError;
                    } ?>
                </span>
            </div>
        </form>

    <!--Div contendo o painel de funcionários, divididos em ativos e inativos-->
    <!--
        para organizar os funcionários com php, retorne dentro de ativos e inativos 
        com a seguinte organização: 

            <p>
                <span>Teste2</span>
                <button onclick="AbrirModal(GerFuncionarios,editarFuncionario)" style="background-color: #8b0d96;">Editar</button>
                <button>"Desativar" quando estiver nos ATIVOS e "Reativar" quando estiver nos INATIVOS</button>
            </p>

        OBS: quando um funcionário estiver desativado, ele deve perder acesso ao sistema
        -->
        <div id="funcionarios">
            <h2><img src="../Imagens/Icones/funcionarios.png" alt="icone funcionários">Funcionários<img src="../Imagens/Icones/funcionarios.png" alt="icone funcionários"></h2>
            <div id="ativos">
                <?php
                $sql = ("SELECT id, CONCAT(first_name, ' ', last_name) AS nomeFunc FROM users WHERE tipo = :tipo AND active = :active");
                $parametros = [
                    ':tipo' => 'employee',
                    ':active' => 1,
                ];
                $result = $db->executar($sql, $parametros, true);
                foreach ($result as $funcionarios) {
                ?>
                    <p><span><?= $funcionarios['nomeFunc'] ?></span><button onclick="AbrirModal(GerFuncionarios, editarFuncionario, <?=$funcionarios['id']?>)" style="background-color: #8b0d96;">Editar</button><button>Desativar</button></p>
                <?php
                }
                ?>
            </div>
            <div id="inativos">
            <?php
                $sql = ("SELECT id, CONCAT(first_name, ' ', last_name) AS nomeFunc FROM users WHERE tipo = :tipo AND active = :active");
                $parametros = [
                    ':tipo' => 'employee',
                    ':active' => 0,
                ];
                $result = $db->executar($sql, $parametros, true);
                foreach ($result as $funcionarios) {
                ?>
                    <p><span><?= $funcionarios['nomeFunc'] ?></span><button onclick="AbrirModal(GerFuncionarios, editarFuncionario, <?=$funcionarios['id']?>)" style="background-color: #8b0d96;">Editar</button><button>Desativar</button></p>
                <?php
                }
                ?>
            </div>
        </div>

    <!--Fundo para os modais-->
    <div style="display: none;" id="GerFuncionarios" class="fundoModal"></div>

    <!--Modal para edição de funcionários-->
    <div style="display:none" class="modal" id="editarFuncionario">
        <img onclick="FecharModal(GerFuncionarios,editarFuncionario)" class="fecharModal" src="../Imagens/Icones/Fechar.png" alt="icone fechar">
        <h2>Nome do funcionario</h2>
        <form class="basicForm">
            <input type="text" id="idFuncionario" name="idFuncionario" readonly>
            <input type="text" placeholder="Mudar endereço">
            <input type="text" placeholder="Mudar Número">
            <input type="email" placeholder="Mudar email">
            <input type="text" placeholder="Mudar Telefone">
            <input type="password" placeholder="Mudar senha">
            <input type="password" placeholder="Confirmar nova senha">
            <input id="editarFuncionário" type="submit" value="Atualizar">
        </form>
    </div>

    <!--Modal para análise de currículos-->
    <!--
        Não precisa habilitar por enquanto, vamos dar prioridade aos requisitos
        do dia 8 de fevereiro
        -->
    <div id="analisarCurriculos" style="display: none;" class="modal">
        <img onclick="FecharModal(GerFuncionarios,analisarCurriculos)" class="fecharModal" src="../Imagens/Icones/Fechar.png" alt="icone fechar">
        <h2><img src="../Imagens/Icones/curriculo.png" alt="icone curriculos"> Currículos</h2>
        <div class="curriculo">
            <h3>Nome + Sobrenome</h3>
            <p><span>Endereço:</span> Endereço</p>
            <p><span>Data de nascimento:</span> Data de nascimento</p>
            <p><span>Telefone:</span> Telefone</p>
            <p><span>Objetivo</span> Objetivo Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium eaque laboriosam dolorem facere provident praesentium magni quae blanditiis asperiores itaque recusandae possimus nisi, nemo perferendis, dolore obcaecati, mollitia molestiae fugit.</p>
            <p><span>Habilidades</span> Habilidades Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum libero ipsam aliquam sunt inventore. Saepe asperiores, voluptas voluptate aliquam, harum aspernatur pariatur in enim ab explicabo quo repudiandae excepturi cupiditate.</p>
            <div class="interagir"> <button class="aceitar"><img src="../Imagens/Icones/aceitar.png" alt="icone aceitar"> Aceitar</button><button class="excluir"><img src="../Imagens/Icones/lixeira.png" alt="icone lixeira"> Excluir</button></div>
        </div>
        <div class="curriculo">
            <h3>Nome + Sobrenome</h3>
            <p><span>Endereço:</span> Endereço</p>
            <p><span>Data de nascimento:</span> Data de nascimento</p>
            <p><span>Telefone:</span> Telefone</p>
            <p><span>Objetivo</span> Objetivo Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium eaque laboriosam dolorem facere provident praesentium magni quae blanditiis asperiores itaque recusandae possimus nisi, nemo perferendis, dolore obcaecati, mollitia molestiae fugit.</p>
            <p><span>Habilidades</span> Habilidades Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum libero ipsam aliquam sunt inventore. Saepe asperiores, voluptas voluptate aliquam, harum aspernatur pariatur in enim ab explicabo quo repudiandae excepturi cupiditate.</p>
            <div class="interagir"> <button class="aceitar"><img src="../Imagens/Icones/aceitar.png" alt="icone aceitar"> Aceitar</button><button class="excluir"><img src="../Imagens/Icones/lixeira.png" alt="icone lixeira"> Excluir</button></div>
        </div>
        <div class="curriculo">
            <h3>Nome + Sobrenome</h3>
            <p><span>Endereço:</span> Endereço</p>
            <p><span>Data de nascimento:</span> Data de nascimento</p>
            <p><span>Telefone:</span> Telefone</p>
            <p><span>Objetivo</span> Objetivo Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium eaque laboriosam dolorem facere provident praesentium magni quae blanditiis asperiores itaque recusandae possimus nisi, nemo perferendis, dolore obcaecati, mollitia molestiae fugit.</p>
            <p><span>Habilidades</span> Habilidades Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum libero ipsam aliquam sunt inventore. Saepe asperiores, voluptas voluptate aliquam, harum aspernatur pariatur in enim ab explicabo quo repudiandae excepturi cupiditate.</p>
            <div class="interagir"> <button class="aceitar"><img src="../Imagens/Icones/aceitar.png" alt="icone aceitar"> Aceitar</button><button class="excluir"><img src="../Imagens/Icones/lixeira.png" alt="icone lixeira"> Excluir</button></div>
        </div>
    </div>

    <script src="../index.js"></script>
</body>

</html>