import Ajax from "./modules/ajax.js";
import View from "./modules/view.js";
import Eloquent from "./modules/blinder/eloquent.js";
import Blinder from "./modules/blinder/blinder.js";
import visible from "./modules/visible.js";

$(document).ready(function () {
    Blinder.handle();

    View.tradeView('loginView');

    $('#cadastrarLink').on('click',function(){
        View.tradeView('cadastroView');
    });

    $('#esqueciSenhaLink').on('click',function(){
        View.tradeView('esqueciView');
    });

    $('.linkVoltarLogin').on('click',function(){
        View.tradeView('loginView');
    });

    $('#btnCadastrarUsuario').on('click', function () {
        let attributes = {
            'emailUsuario': $('#loginCadastro').val(),
            'senhaUsuario': $('#senhaCadastro').val(),
            'nomeUsuario': $('#nomeCadastro').val(),
            'codigoTipoUsuario': $('#selectTipoUsuario option:selected').val(),
        };
        Ajax.setAttributes(attributes).setUrl('usuario/criar').send(function (data) {
            visible.comunicate(data);
        });
    });

    $('#btnEntrar').on('click', function () {
        let attributes = {
            'email': $('#loginText').val(),
            'senha': $('#senhaText').val(),
        };
        Ajax.setAttributes(attributes).setUrl('login').send(function(data){
            Eloquent.speakText('Seu login foi validado. Entrando no sistema.');
        });
    });
})


