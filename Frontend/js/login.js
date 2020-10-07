import Ajax from "./modules/ajax.js";
import View from "./modules/view.js";
import Eloquent from "./modules/blinder/eloquent.js";
import Blinder from "./modules/blinder/blinder.js";
import visible from "./modules/visible.js";
import Storage from "./modules/storage/storage.js";

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
        Ajax.setAttributes(attributes).setUrl('usuario/criar').send(function (response, request) {
            const type = response.codigo === 200 ? 'success' : '#errorCadastrar'
            let speak = response.mensagem

            if(Array.isArray(response))
                speak = response.mensagem.join('<br/>')

            visible.comunicate(speak,type)

            if(type !== 'success')
                return false;

            return logar(request.emailUsuario, request.senhaUsuario, false)
        });
    });

    $('#btnEntrar').on('click', function () {
        logar($('#loginText').val(), $('#senhaText').val())
    });

    function logar (usuario, senha, showMessage = true) {
        let attributes = {
            'email': usuario,
            'senha': senha,
        };
        Ajax.setAttributes(attributes).setUrl('login').send(function(response){
            const type = response.codigo === 200 ? 'success' : '#errorLogar'
            let speak = 'Seu login foi validado. Entrando no sistema.'

            if(type !== 'success') {
                speak = Array.isArray(response.mensagem) ? response.mensagem.join('<br/>') : response.mensagem
                visible.comunicate(speak,type)

                return false;
            }

            if(showMessage)
                visible.comunicate(speak,type)

            Storage.save('user', response.mensagem)

            setTimeout(() => {
                switch (response.mensagem.codigoTipoUsuario) {
                    case '1':
                        location.href = '/html/Aluno/homeAluno.html'
                        break;
                    default:
                        location.href = '/html/Professor/homeProfessor.html'
                }
            },1000);
        });
    }
})


