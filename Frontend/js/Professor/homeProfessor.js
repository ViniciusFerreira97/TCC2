import Ajax from "../modules/ajax.js";
import View from "../modules/view.js";
import Eloquent from "../modules/blinder/eloquent.js";
import Blinder from "../modules/blinder/blinder.js";

var codigoAtividade = null;

$(document).ready(function($){
    Blinder.handle();

    $('#btnCadastrarAtividade').on('click',function(){
        View.tradeView('cadastroProfessor');
    });
    
    $('#novaAtividade').on('click',function(){
        View.tradeView('viewNovaAtividade');
    });

    $('#btnVoltarCadastro').on('click',function(){
        View.tradeView('viewNovaAtividade');
    });

    $('#cadastrarAtividade').on('click', function () {
        let attributes = {
            'tituloAtividade': $('#inputTitulo').val(),
            'descricaoAtividade': $('#inputDescricao').val(),
            'dataAtividade': $('#inputData').val(),
            'tempoAtividade': $('#inputTempo').val(),
        };
        Ajax.setAttributes(attributes).setUrl('atividade/criar').send(function (data) {
            if(data.codigo == 200)
            {
                View.tradeView('viewCadastroQuestoes');
            } 
        });
    });

    $('#salvarQuestao').on('click', function () {
        let enunciado = $('#inputEnunciado').val();
        let attributes = {
            'enunciado': enunciado,
            'alternativaA': $('#alternativaA').val(),
            'alternativaB': $('#alternativaB').val(),
            'alternativaC': $('#alternativaC').val(),
            'alternativaD': $('#alternativaD').val(),
            'alternativaE': $('#alternativaE').val()
        };

        Ajax.setAttributes(attributes).setUrl('atividade/questao/criar').send(function (data) {
            console.log(data);
        });
        
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
                <button type="button" class="btn btn-info btn-sm verQuestao"><i
                        class="far fa-eye"></i></button>
                <button type="button" id="adicionarQuestao" class="btn btn-unique btn-sm"><i
                        class="fas fa-trash-alt"></i></button>
            </td>
        </tr>`;
        $('#tBodyInsert').append(htmlGerado);
    });

    $('.btnGroupClick').on('click', function () {
        $('.divAlternativas').attr('hidden', 'true');
        $(".btnGroupClick").removeClass("btn-unique").addClass("btn-light");
        $(this).removeClass("btn-light").addClass("btn-unique");
        $(`#divAlternativa${$(this).text()}`).removeAttr('hidden');
    })

    $(document).on('click', '.verQuestao', function () {
        $('#centralModalSm').modal('show');
    });

    $('#inputData').mask('00/00/0000');
    $('#inputTempo').mask('00:00');

})


