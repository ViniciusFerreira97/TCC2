import Ajax from "../modules/ajax.js";
import View from "../modules/view.js";
import Eloquent from "../modules/blinder/eloquent.js";
import Blinder from "../modules/blinder/blinder.js";
import Storage from "../modules/storage/storage.js";

var codigoAtividade = null;
const user = Storage.get('user');

$(document).ready(function($){
    Blinder.handle();

    $('#btnCadastrarAtividade').on('click',function(){
        View.tradeView('cadastroProfessor');
        carregarTabela();
    });
    
    $('#novaAtividade').on('click',function(){
        View.tradeView('viewNovaAtividade');
    });

    $('#logoHomeClick').on('click',function(){
        View.tradeView('homeProfessor');
    });

    $('#btnVoltarCadastro').on('click',function(){
        View.tradeView('viewNovaAtividade');
    });

    function dadosHome()
    {
        
        Ajax.setType('GET').setUrl(`home/dados/listar/${user.codigoUsuario}`).send(function (data) {
            if(data.codigo == 200)
            {
                let elemento = data.mensagem;
                $('#homeAlunosCadastrados').html(elemento.contadorAlunos);
                $('#homeProfessoresCadastrados').html(elemento.contadorProfessores);
                $('#homeAtividadesCadastrados').html(elemento.contadorAtividades);
                $('#homeQuestoesCadastradas').html(elemento.contadorQuestoes);
                $('#homeQuestoesRespondidas').html(elemento.contadorRespostas);
                //doughnut
                var ctxD = document.getElementById("doughnutChart").getContext('2d');
                var myLineChart = new Chart(ctxD, {
                type: 'doughnut',
                data: {
                labels: ["Erros", "Acertos"],
                datasets: [{
                data: [elemento.errosGrafico, elemento.acertosGrafico],
                backgroundColor: ["rgba(183, 28, 28, 0.8)", "rgba(27, 94, 32, 0.8)"],
                hoverBackgroundColor: ["#d32f2f", "#2e7d32"]
                }]
                },
                options: {
                responsive: true
                }
                });

                let realizadasGrafico2 = elemento.atividadesRealizadasGrafico > 0 ? elemento.atividadesRealizadasGrafico : 1;
                let naoRealizadasGrafico2 = elemento.atividadesNaoRealizadasGrafico > 0 ? elemento.atividadesNaoRealizadasGrafico : 1;
                var ctxD = document.getElementById("doughnutChart2").getContext('2d');
                var myLineChart = new Chart(ctxD, {
                type: 'doughnut',
                data: {
                labels: ["Realizadas", "Não Realizadas"],
                datasets: [{
                data: [realizadasGrafico2, naoRealizadasGrafico2],
                backgroundColor: ["rgba(13, 71, 161, 0.8)", "rgba(0, 137, 123, 0.8)"],
                hoverBackgroundColor: ["#1976d2", "#00695c"]
                }]
                },
                options: {
                responsive: true
                }
                });
            }
        });
    }
    dadosHome();

    function carregarTabela(){
        $('#tdInicialInsert').empty();
        Ajax.setType('GET').setUrl(`atividade/listar/${user.codigoUsuario}/0`).send(function (data) {
            if(data.codigo == 200)
            {
                var htmlTabela = '';
                data.mensagem.map(elemento => {
                    let data = new Date(elemento.data_maxima);
                    data = data.toLocaleDateString('pt-BR');
                    htmlTabela += `<tr class="d-flex">
                        <th class="text-center col-2">${elemento.cd_atividade}</th>
                        <td class="text-center col-5">${elemento.titulo}</td>
                        <td class="text-center col-2">${data}</td>
                        <td class="text-center col-2">${elemento.tempo}</td>
                        <td class="text-center col-1">
                            <button type="button" codigoAtividade="${elemento.cd_atividade}" class="btn btn-unique btn-sm apagarAtividade"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>`
                })
                $('#tdInicialInsert').append(htmlTabela);
            }
        });
    }

    $('#cadastrarAtividade').on('click', function () {
        let attributes = {
            'codigoAtividade': codigoAtividade,
            'tituloAtividade': $('#inputTitulo').val(),
            'descricaoAtividade': $('#inputDescricao').val(),
            'dataAtividade': $('#inputData').val(),
            'tempoAtividade': $('#inputTempo').val(),
            'codigoUsuario': user.codigoUsuario
        };
        Ajax.setAttributes(attributes).setUrl('atividade/criar').send(function (data) {
            if(data.codigo == 200)
            {
                codigoAtividade = data.mensagem.cd_atividade;
                View.tradeView('viewCadastroQuestoes');
            }
        });
    });

    $('#salvarQuestao').on('click', function () {
        let enunciado = $('#inputEnunciado').val();
        if($('#slctRespostaCorreta').val() == 0 || $('#slctRespostaCorreta').val() == '')
        {
            alert('A resposta correta é obrigatória.');
            return false;
        }
        let attributes = {
            'enunciado': enunciado,
            'codigoAtividade': codigoAtividade,
            'respostaCorreta' : $('#slctRespostaCorreta').val(),
            'alternativaA': $('#alternativaA').val(),
            'alternativaB': $('#alternativaB').val(),
            'alternativaC': $('#alternativaC').val(),
            'alternativaD': $('#alternativaD').val(),
            'alternativaE': $('#alternativaE').val()
        };

        Ajax.setAttributes(attributes).setUrl('atividade/questao/criar').send(function (data) {
            if(data.codigo == 200)
            {
                if(enunciado.length > 64)
                {
                    enunciado = enunciado.substr(0,64);
                    enunciado += '...';
                }
                let htmlGerado = 
                `<tr class="d-flex">
                    <th class="text-center col-2">1</th>
                    <td class="text-center col-8">${enunciado}</td>
                    <td class="text-center col-2">
                        <button type="button" class="btn btn-info btn-sm verQuestao" codigoQuestao="${data.mensagem.cd_atividade_questao}"><i
                                class="far fa-eye"></i></button>
                        <button type="button" codigoQuestao="${data.mensagem.cd_atividade_questao}" class="btn btn-unique btn-sm apagarQuestao"><i
                                class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>`;
                $('#tBodyInsert').append(htmlGerado);
                limparCamposQuestao();
            }
        });
    });

    $('.btnGroupClick').on('click', function () {
        $('.divAlternativas').attr('hidden', 'true');
        $(".btnGroupClick").removeClass("btn-unique").addClass("btn-light");
        $(this).removeClass("btn-light").addClass("btn-unique");
        $(`#divAlternativa${$(this).text()}`).removeAttr('hidden');
    })

    $('.apagarQuestao').on('click', function(){

    });

    $(document).on('click', '.verQuestao', function () {
        let codigoQuestao = $(this).attr('codigoQuestao');
        codigoQuestao = codigoQuestao.trim();
        Ajax.setType('GET').setUrl(`dados/questao/listar/${codigoQuestao}`).send(function (data) {
            $('#divInsertOptions').empty();
            $('#idEnunciadoModal').html(data.mensagem.enunciado);
            let arrayQuestoes = ['A', 'B', 'C', 'D', 'E'];
            let htmlOptions = '';
            for(let i=0; i<5; i++)
            {
                htmlOptions+=`<p>
                                <input type="radio" class="option-input radio" name="example" ${data.mensagem.ds_resposta_correta == arrayQuestoes[i] ? 'checked':''} />
                                ${data.mensagem[`alternativa${arrayQuestoes[i]}`]}
                            </p>`
            }
            $('#divInsertOptions').append(htmlOptions);
            $('#centralModalSm').modal('show');
        });
    });

    $('#inputData').mask('00/00/0000');
    $('#inputTempo').mask('00:00');

    function limparCamposQuestao()
    {
        $('#slctRespostaCorreta').val(0);
        $('#btnGroupClickA').trigger('click');
        $('.limparQuestao').each(function(){
            $(this).val('');
        });
    }

})

