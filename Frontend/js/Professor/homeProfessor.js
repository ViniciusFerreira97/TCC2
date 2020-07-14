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
})


