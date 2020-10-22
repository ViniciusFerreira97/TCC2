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

    <link rel="stylesheet" href="../../css/geral.css">
    <link rel="stylesheet" href="../../css/Aluno/mainMenu.css">
</head>

<body>
<nav class="fixed-bottom">
    <div class="row text-center">
        <div class="col">
            <a href="#" class="white-text" id="tradeHome">
                <i class="fas fa-home"></i>
            </a>
        </div>
        <div class="col">
            <a href="#" class="white-text" id="tradeAtividade">
                <i class="fas fa-tasks"></i>
            </a>
        </div>
        <div class="col">
            <a href="#" class="white-text" id="tradeProcurar">
                <i class="fas fa-search"></i>
            </a>
        </div>
        <div class="col">
            <a href="#" class="white-text" id="tradeUser">
                <i class="fas fa-user"></i>
            </a>
        </div>
    </div>
    <section class="view" id="menuView">
        <div class="blinderItem" id="menuAlunoBlinder">
            <item name="Lista de Atividade" action="click" target="#tradeAtividade" synonym="Lista de"/>
            <item name="Procurar Atividade" action="click" talk="Qual tarefa iremos realizar ?" target="#tradeProcurar" synonym="Procurar"/>
            <item name="Opções de usuário" action="click" target="#tradeUser" synonym="opções de uso"/>
        </div>
    </section>
</nav>

<div class="mb-2 mt-2 text-center p-2">
    <img src="/images/logo/oMaior.png" class="logoTop">
</div>
<hr>
<main class="text-center mt-5">
    <section class="d-none view" id="homeView">
        <div>
            <h3>
                Olá, <span class="userName"></span>.
            </h3>
        </div>
        <div>
            <h4>O que faremos hoje ?</h4>
        </div>
        <div class="row mt-5">
            <div class="col">
                <hr>
            </div>
        </div>
        <section>
            <div class="row p-3 font-weight-bold" id="procurarAtividadeAtalho">
                <div class="col">
                <span class="p-2 rounded rgba-grey-slight mr-3">
                    <i class="fas fa-search"></i>
                </span>
                    Procurar Atividade
                </div>
            </div>
            <hr>
            <div class="row p-3 font-weight-bold" id="historicoAtividadesAtalho">
                <div class="col">
                <span class="p-2 rounded rgba-grey-slight mr-3">
                    <i class="fas fa-list"></i>
                </span>
                    Histórico de atividades
                </div>
            </div>
            <hr>
        </section>
    </section>
    <section class="h-100 view d-none" id="atividadesView">
        <section id="mainAtividadeView" class="">
            <div>
                <h4>Sua lista de atividades</h4>
            </div>
            <div class="mt-5">
                <ul class="list-group" id="listaTarefas">

                </ul>
            </div>
            <div class="mt-5 d-none" id="listaTarefasVazio">
                Sem tarefas.
            </div>
        </section>
        <section id="tarefaAtividadeView" class="d-none">
            <h3 class="titulo"> Titulo </h3>

            <div class="font-weight-bold mt-5">
                Questão <span class="questaoNumero"></span>
            </div>
            <div class="font-weight-bolder mt-5 textoQuestao"></div>
            <div class="mt-5 letrasQuestao"></div>
            <div class="mt-5 d-flex justify-content-around">
                <button type="button" class="btn light-blue white-text d-none" id="btnVoltarTarefa">
                    Voltar
                </button>
                <button type="button" class="btn btn-pink d-none" id="btnProximaTarefa">
                    Próxima
                </button>
            </div>
            <button type="button" class="btn d-none" id="btnRepetirTarefa">
                Repetir
            </button>
        </section>
        <section id="resultadoAtividadeView" class="d-none">
            <h3>Resultado da atividade</h3>
            <div class="mt-5">
                <h4>Acertos</h4>
                <h2 class="text-success"> 50 </h2>
            </div>
            <div class="mt-5">
                <h4>Erros</h4>
                <h2 class="text-danger"> 50 </h2>
            </div>
            <button type="button" class="btn light-blue white-text mt-5" id="btnVoltarInicioTarefa">
                Voltar
            </button>
        </section>
         <div class="blinderItem" id="listaViewBlinder">
         </div>
    </section>
    <section class="h-100 view d-none" id="procurarView">
        <h4>
            Qual atividade iremos realizar ?
        </h4>
        <div class="d-flex justify-content-center mt-5">
            <input type="text" id="codigoTarefaTxt" class="form-control w-75" placeholder="Insira o código da tarefa">
        </div>
        <button type="button" class="btn light-blue white-text mt-3" id="btnPesquisarTarefa">
            Pesquisar
        </button>
        <div class="d-flex justify-content-center mt-5">
            <section class="text-white danger-color p-2 rounded d-none" id="tarefaNaoEncontradaPesquisa">
                Tarefa
            </section>
        </div>
        <section id="tarefaProcurada" class="d-none">
            <div class="d-flex justify-content-center mt-5">
                <section class="w-75 border rounded p-4">
                    <h5 class="m-2">
                        <span id="tituloTarefaPesquisada"> 15/09/2020 </span>
                    </h5>
                    <h5 class="m-2">
                        Por: <span id="criadorTarefaPesquisada">Marcus Silva Jr.</span>
                    </h5>
                    <h5 class="m-2">
                        Expiração: <span id="dataTarefaPesquisada"> 15/09/2020 </span>
                    </h5>
                </section>
            </div>
            <button type="button" class="btn btn-pink mt-5" id="btnAdicionarTarefa">
                Adicionar Atividade
            </button>
        </section>
        <div class="blinderItem" id="procurarViewBlinder">
            <item name="Código" action="insert" value="" talk="Código inserido: [[talk]]" target="#codigoTarefaTxt"></item>
            <item name="Pesquisar" action="click" target="#btnPesquisarTarefa"></item>
        </div>
    </section>
    <section class="h-100 d-none view" id="userView">
        <div>
            <i class="fas fa-user-circle fa-4x"></i>
        </div>
        <h4 class="mt-3">
            <span class="userName"></span>
        </h4>
        <div class="mt-5">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="checkAcessibilidade">
                <label class="form-check-label" for="checkAcessibilidade">Acessibilidade</label>
            </div>
        </div>
        <div class="align-text-bottom mt-5">
            <button type="button" class="btn btn-pink" id="btnSair">Sair</button>
        </div>
        <div class="blinderItem" id="loginViewBlinder">
            <item name="Desativar acessibilidade" action="check" value="false" talk="Desativando acessibilidade" target="#checkAcessibilidade"/>
            <item name="Sair" action="click" talk="Saindo do sistema" target="#btnSair"/>
        </div>
    </section>
</main>

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

</body>

<script type="text/javascript" src="/mdb/js/jquery.min.js"></script>
<script type="text/javascript" src="/mdb/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/mdb/js/mdb.min.js"></script>
<script type="text/javascript" src="/mdb/js/popper.min.js"></script>
<script src="https://kit.fontawesome.com/7d3e7301a3.js" crossorigin="anonymous"></script>

<script type="module" src="/js/Aluno/main.js"></script>
</html>
