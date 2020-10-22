<!DOCTYPE html>
<html>
<head lang="pt-BR">
    <title>iVision</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="icon" type="image/png" href="/images/logo/oOriginal.png"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="PWA">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="72x72" href="/images/logo/ios/72x72.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/images/logo/ios/144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/images/logo/ios/152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/logo/ios/180x180.png">
    <!-- MDB Itens -->
    <link href="/mdb/css/bootstrap.min.css" rel="stylesheet">
    <link href="/mdb/css/mdb.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/css/login.css">
    <link rel="stylesheet" href="../css/geral.css">
</head>

<body>

<div class="text-center mt-5">
    <img src="/images/logo/iVisionLogo.png" class="img-fluid w-50" alt="Logo Aplicativo (iVision)">
</div>

<section class="view d-none" id="loginView">
    <div class="formContent">
        <div class="text-center mt-5">
            <h3 class="text-bold">Entrar no iVision</h3>
        </div>
        <div class="text-center ml-2 mr-2 pr-3 pl-3">
            <div class="md-form">
                <input type="text" id="loginText" class="form-control">
                <label for="loginText">E-mail</label>
            </div>
        </div>
        <div class="text-center ml-2 mr-2 pr-3 pl-3">
            <div class="md-form">
                <input type="password" id="senhaText" class="form-control">
                <label for="senhaText">Senha</label>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col p-4 mr-3 ml-1">
                <button id="btnEntrar" type="button" class="btn btn-lg pink accent-1 white-text w-100">Entrar</button>
            </div>
        </div>
    </div>
    <div class="row pr-3 pl-5 d-none">
        <div class="col">
            <a href="#" id="esqueciSenhaLink">Esqueceu a senha?</a>
        </div>
        <div class="col">
            <a href="#" id="cadastrarLink">Cadastrar-se</a>
        </div>
    </div>
    <div class="row p-5 text-center">
        <div class="col d-none danger-color text-white p-3 rounded" id="errorLogar">

        </div>
    </div>
    <div class="blinderItem" id="loginViewBlinder">
        <item name="E-mail" action="insert" talk="Email inserido: [[talk]]" value="" target="#loginText"/>
        <item name="Senha" action="insert" talk="Senha inserida: [[talk]]" value="" target="#senhaText"/>
        <item name="Entrar" action="click" target="#btnEntrar"/>
        <!-- <item name="Esqueci minha senha" action="click" target="#esqueciSenhaLink" talk="Menu de Esqueci minha senha disponível."/>
        <item name="Cadastrar-me" action="click" target="#cadastrarLink" synonym="Cadastrar"/> -->
    </div>
</section>

<section class="view d-none" id="cadastroView">
    <div class="formContent">
        <div class="text-center mt-5">
            <h3 class="text-bold">Recuperar senha</h3>
        </div>
        <div class="text-center ml-2 mr-2 pr-3 pl-3">
            <div class="md-form">
                <input type="text" id="loginCadastro" class="form-control">
                <label for="loginCadastro">E-mail</label>
            </div>
        </div>
        <div class="text-center ml-2 mr-2 pr-3 pl-3">
            <div class="md-form">
                <input type="password" id="senhaCadastro" class="form-control">
                <label for="senhaCadastro">Senha</label>
            </div>
        </div>
        <div class="text-center ml-2 mr-2 pr-3 pl-3">
            <div class="md-form">
                <input type="text" id="nomeCadastro" class="form-control">
                <label for="nomeCadastro">Nome</label>
            </div>
        </div>
        <div class="text-center ml-2 mr-2 pr-3 pl-3">
            <select id="selectTipoUsuario" class="browser-default custom-select">
                <option value="0" disabled>Selecione o tipo de usuário</option>
                <option value="1">Aluno</option>
                <option value="2">Professor</option>
            </select>
        </div>
    </div>
    <div class="row mt-5 ml-4">
        <div class="col-5 text-center">
            <button type="button" class="btn light-blue white-text linkVoltarLogin">Voltar</button>
        </div>
        <div class="col-5 text-center">
            <button type="button" id="btnCadastrarUsuario" class="btn pink accent-1 white-text">Cadastrar</button>
        </div>
    </div>

    <div class="row p-5">
        <div class="col d-none danger-color text-white p-3 rounded" id="errorCadastrar">

        </div>
    </div>

    <div class="blinderItem" id="cadastroViewBlinder">
        <item name="E-mail" action="insert" value="" target="#loginCadastro"/>
        <item name="Senha" action="insert" value="" target="#senhaCadastro"/>
        <item name="Nome" action="insert" value="" target="#nomeCadastro"/>
        <item name="Tipo de usuário" action="insert" value="" target="#selectTipoUsuario"
                alt="Valores disponíveis: Aluno e Professor."/>
        <item name="Voltar" action="click" target=".linkVoltarLogin" talk="Menu de Login disponível."/>
        <item name="Cadastrar" action="click" target="#btnCadastrarUsuario"/>
    </div>
</section>

<section class="view d-none" id="esqueciView">
    <div class="formContent">
        <div class="text-center mt-5">
            <h3 class="text-bold">Esqueci minha senha</h3>
        </div>
        <div class="text-center ml-2 mr-2 pr-3 pl-3">
            <div class="md-form">
                <input type="text" id="loginEsqueci" class="form-control">
                <label for="loginEsqueci">E-mail</label>
            </div>
        </div>
    </div>

    <div class="row mt-5 ml-4">
        <div class="col-5 text-center">
            <button type="button" class="btn light-blue white-text linkVoltarLogin">Voltar</button>
        </div>
        <div class="col-5 text-center">
            <button id="btnRecuperarSenha" type="button" class="btn pink accent-1 white-text">Recuperar</button>
        </div>
    </div>

    <div class="blinderItem" id="esqueciViewBlinder">
        <item name="E-mail" action="insert" value="" target="#loginEsqueci"/>
        <item name="Voltar" action="click" target=".linkVoltarLogin" talk="Menu de Login disponível."/>
        <item name="Cadastrar" action="click" target="#btnRecuperarSenha"/>
    </div>
</section>

<section id="firstLoginContent" class="text-center align-middle white-text">
    <h3 class="d-none">Seja bem vindo, clique para continuar.</h3>
    <h3 class="d-none mt-2">Deseja manter o contole de voz ativo ?</h3>
    <h3 class="d-none mt-2">Clique para o começarmos a te ouvir.</h3>
    <h3 class="d-none mt-2">Depois responda sim ou não e clique novamente para continuar.</h3>
</section>

</body>

<div class="modal fade top" id="alert-success" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-full-height modal-top" role="document">
        <div class="modal-content success-color text-white">
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>

<div class="modal fade top" id="alert-error" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-full-height modal-top" role="document">
        <div class="modal-content danger-color text-white">
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="/mdb/js/jquery.min.js"></script>
<script type="text/javascript" src="/mdb/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/mdb/js/mdb.min.js"></script>
<script type="text/javascript" src="/mdb/js/popper.min.js"></script>
<script src="https://kit.fontawesome.com/7d3e7301a3.js" crossorigin="anonymous"></script>

<script type="module" src="/js/main.js"></script>
<script type="module" src="/js/login.js"></script>
</html>
