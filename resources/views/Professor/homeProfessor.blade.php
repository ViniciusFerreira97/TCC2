<!DOCTYPE html>
<html>

<head lang="pt-BR">
    <title>Home</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="manifest" href="/manifest.webmanifest" />
    <link rel="icon" type="image/png" href="/images/logo/oOriginal.png" />
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
    <!-- <link rel="stylesheet" href="/css/login.css"> -->
    <link rel="stylesheet" href="../../css/geral.css">
    <link rel="stylesheet" href="../../css/check.css">
</head>

<body>

    <div class="row">
        <div class="col-12">
            <nav class="mb-1 navbar navbar-expand-lg navbar-dark blue lighten-2">
                <a class="navbar-brand" id="logoHomeClick" href="javascript:void(0);"><img src="/images/logo/android/36x36.png" class="img-fluid"
                        alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navBarProfessor"
                    aria-controls="navBarProfessor" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navBarProfessor">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item" id="btnCadastrarAtividade">
                            <a class="nav-link" href="javascript:void(0);">
                                <i class="fas fa-clipboard-list"></i>Cadastrar Atividade
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="perfilNavBarProfessor" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="far fa-user"></i> Perfil</a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-info"
                                aria-labelledby="perfilNavBarProfessor">
                                <a class="dropdown-item" id="btnMinhaConta" href="javascript:void(0);">Minha Conta</a>
                                <a class="dropdown-item" id="btnSair" href="/login">Sair</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>

    <section class="view" id="homeProfessor">
        <div class="row mt-1 text-center">
            <div class="col-1"></div>
            <div class="col-10">
                <h3>Bem vindo Professor</h3>
                <hr class="w-50">
            </div>
        </div>

        <div class="row p-3 mt-3 text-center">
            <div class="col-1"></div>
            <div class="col-2">
                <div class="card indigo darken-4">
                    <div class="card-body">
                        <h5 class="card-title text-light"><a><i class="fas fa-user-graduate text-success"></i> Alunos Cadastrados</a></h5>
                        <h5 class="card-title text-success" id="homeAlunosCadastrados"></h5>

                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card indigo darken-4">
                    <div class="card-body">
                        <h5 class="card-title text-light"><a><i class="fas fa-user-cog text-success"></i> Professores Cadastrados</a></h5>
                        <h5 class="card-title text-success" id="homeProfessoresCadastrados"></h5>

                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card indigo darken-4">
                    <div class="card-body">
                        <h5 class="card-title text-light"><a><i class="fas fa-list text-success"></i> Atividades Cadastradas</a></h5>
                        <h5 class="card-title text-success" id="homeAtividadesCadastrados"></h5>

                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card indigo darken-4">
                    <div class="card-body">
                        <h5 class="card-title text-light"><a><i class="fas fa-question text-success"></i> Questões Cadastradas</a></h5>
                        <h5 class="card-title text-success" id="homeQuestoesCadastradas"></h5>

                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card indigo darken-4">
                    <div class="card-body">
                        <h5 class="card-title text-light"><a><i class="fas fa-spell-check text-success"></i> Questões Respondidas</a></h5>
                        <h5 class="card-title text-success" id="homeQuestoesRespondidas"></h5>

                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3 text-center">
            <div class="col-1"></div>
            <div class="col-5">
                <h4>Dados Gerais Questões</h4>
                <hr>
                <canvas class="mt-3" id="doughnutChart"></canvas>
            </div>
            <div class="col-5">
                <h4>Atividades - Realizadas x Não Realizadas</h4>
                <hr>
                <canvas id="doughnutChart2"></canvas>
            </div>
        </div>
    </section>

    <section class="view mt-3 d-none" id="cadastroProfessor">
        <div class="row">
            <div class="col-11">
                <button type="button" id="novaAtividade" class="btn btn-primary btn-sm float-right">Cadastrar
                    Atividade</button>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-1"></div>
            <div class="col-10">
                <table class="table table-sm">
                    <thead>
                        <tr class="d-flex">
                            <th class="text-center col-2">Código</th>
                            <th class="text-center col-5">Enunciado</th>
                            <th class="text-center col-2">Data Maxima Realização</th>
                            <th class="text-center col-2">Tempo Realização</th>
                            <th class="text-center col-1">Ação</th>
                        </tr>
                    </thead>
                    <tbody id="tdInicialInsert">
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="view mt-4 d-none" id="viewNovaAtividade">
        <div class="row">
            <div class="col text-center">
                <h3>Nova Atividade</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10 text-center">
                <div class="md-form">
                    <input type="text" id="inputTitulo" class="form-control">
                    <label for="inputTitulo">Título Atividade</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10 text-center">
                <div class="md-form">
                    <input type="text" id="inputDescricao" class="form-control">
                    <label for="inputDescricao">Descrição Atividade</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-1"></div>
            <div class="col-5 text-center">
                <div class="md-form">
                    <input type="text" id="inputData" class="form-control">
                    <label for="inputData">Data Máxima</label>
                </div>
            </div>
            <div class="col-5 text-center">
                <div class="md-form">
                    <input type="text" id="inputTempo" class="form-control">
                    <label for="imputTempo">Tempo Realização (HH:MM)</label>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-1"></div>
            <div class="col-10 text-center">
                <button type="button" id="cadastrarAtividade" class="btn btn-success btn-sm w-100">Salvar e
                    Avançar</button>
            </div>
        </div>
    </section>

    <section class="view mt-4 d-none" id="viewCadastroQuestoes">
        <div class="row">
            <div class="col text-center">
                <h3>Cadastrar Questões</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10 text-center">
                <div class="md-form">
                    <textarea id="inputEnunciado" class="md-textarea form-control limparQuestao" rows="3"></textarea>
                    <label for="inputEnunciado">Enunciado Questão</label>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-4"></div>
            <div class="col-4">
                <label>Resposta Correta</label>
                <select class="browser-default custom-select" id="slctRespostaCorreta">
                    <option selected="" value="0">Selecione</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                    <option value="E">E</option>
                </select>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-1"></div>
            <div class="col-4">
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-unique btn-sm btnGroupClick" id="btnGroupClickA">A</button>
                    <button type="button" class="btn btn-light btn-sm btnGroupClick" id="btnGroupClickB">B</button>
                    <button type="button" class="btn btn-light btn-sm btnGroupClick" id="btnGroupClickC">C</button>
                    <button type="button" class="btn btn-light btn-sm btnGroupClick" id="btnGroupClickD">D</button>
                    <button type="button" class="btn btn-light btn-sm btnGroupClick" id="btnGroupClickE">E</button>
                </div>
            </div>
            <div class="col-6">
                <div class="md-form divAlternativas" id="divAlternativaA">
                    <textarea id="alternativaA" class="md-textarea form-control limparQuestao" rows="3"></textarea>
                    <label for="alternativaA">Resposta Questão A</label>
                </div>
                <div class="md-form divAlternativas" id="divAlternativaB" hidden>
                    <textarea id="alternativaB" class="md-textarea form-control limparQuestao" rows="3"></textarea>
                    <label for="alternativaB">Resposta Questão B</label>
                </div>
                <div class="md-form divAlternativas" id="divAlternativaC" hidden>
                    <textarea id="alternativaC" class="md-textarea form-control limparQuestao" rows="3"></textarea>
                    <label for="alternativaC">Resposta Questão C</label>
                </div>
                <div class="md-form divAlternativas" id="divAlternativaD" hidden>
                    <textarea id="alternativaD" class="md-textarea form-control limparQuestao" rows="3"></textarea>
                    <label for="alternativaD">Resposta Questão D</label>
                </div>
                <div class="md-form divAlternativas" id="divAlternativaE" hidden>
                    <textarea id="alternativaE" class="md-textarea form-control limparQuestao" rows="3"></textarea>
                    <label for="alternativaE">Resposta Questão E</label>
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-1"></div>
            <div class="col-2 text-center">
                <button type="button" class="float-left btn btn-outline-danger waves-effect"
                    id="btnVoltarCadastro">Voltar</button>
            </div>
            <div class="col-6"></div>
            <div class="col-2 text-center">
                <button type="button" class="float-right btn btn-outline-success waves-effect" id="salvarQuestao">Salvar
                    Questão</button>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-1"></div>
            <div class="col-10">
                <hr>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-1"></div>
            <div class="col-10">
                <table class="table table-sm">
                    <thead>
                        <tr class="d-flex">
                            <th class="text-center col-2">Código</th>
                            <th class="text-center col-8">Enunciado</th>
                            <th class="text-center col-2">Ação</th>
                        </tr>
                    </thead>
                    <tbody id="tBodyInsert">
                    </tbody>
                </table>
            </div>
        </div>
    </section>




    <div class="modal fade" id="centralModalSm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header unique-color">
                    <h4 class="modal-title w-100 text-white" id="myModalLabel">Detalhamento Questão</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-10">
                            <p id="idEnunciadoModal">
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-10">
                            <div id="divInsertOptions">
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger waves-effect btn-sm"
                        data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

</body>

<!-- MDB itens -->
<script type="text/javascript" src="/mdb/js/jquery.min.js"></script>
<script type="text/javascript" src="/mdb/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/mdb/js/mdb.min.js"></script>
<script type="text/javascript" src="/mdb/js/popper.min.js"></script>
<script src="https://kit.fontawesome.com/7d3e7301a3.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

<script src="/js/worker_register.js"></script>
<script type="module" src="/js/main.js"></script>
<script type="module" src="/js/Professor/homeProfessor.js"></script>
<!-- <script type="module" src="/js/login.js"></script> -->

</html>