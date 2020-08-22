import Ajax from "../modules/ajax.js";
import View from "../modules/view.js";
import Eloquent from "../modules/blinder/eloquent.js";
import Blinder from "../modules/blinder/blinder.js";

$(document).ready(function () {
    Blinder.handle();

    $('#btnCadastrarAtividade').on('click',function(){
        View.tradeView('cadastroProfessor');
    });
    
    $('#novaAtividade').on('click',function(){
        View.tradeView('viewNovaAtividade');
    });

    $('#cadastrarAtividade').on('click', function () {
        let attributes = {
            'emailUsuario': $('#inputTitulo').val(),
            'senhaUsuario': $('#inputDescricao').val(),
        };
        Ajax.setAttributes(attributes).setUrl('atividade/criar').send(function (data) {
            alert(teste);
            console.log(Ajax.emailUsuario);
        });
    });

})


