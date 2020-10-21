import Ajax from "./modules/ajax.js";
import View from "./modules/view.js";
import Blinder from "./modules/blinder/blinder.js";
import visible from "./modules/visible.js";
import Storage from "./modules/storage/storage.js";
import Eloquent from "./modules/blinder/eloquent.js";

$(document).ready(function () {
    let googleJacu = false
    let ouvirPrimeiroLogin = false
    let posAudicaoPrimeiroLogin = false
    firstLogin();

    function initialize() {
        Blinder.handle();

        View.tradeView('loginView');
    }

    function logar(usuario, senha, showMessage = true) {
        let attributes = {
            'email': usuario,
            'senha': senha,
        };
        Ajax.setAttributes(attributes).setUrl('login').send(function (response) {
            const type = response.codigo === 200 ? 'success' : '#errorLogar'
            let speak = 'Seu login foi validado. Entrando no sistema.'

            if (type !== 'success') {
                visible.comunicate(speak, type)

                return false;
            }

            if (showMessage)
                visible.comunicate(speak, type)

            Storage.save('user', response.mensagem)

            setTimeout(() => {
                switch (parseInt(response.mensagem.codigoTipoUsuario)) {
                    case 1:
                        location.href = '/html/Aluno/homeAluno.html'
                        break;
                    default:
                        location.href = '/html/Professor/homeProfessor.html'
                }
            }, 1000);
        });
    }

    function firstLogin() {
        const first = Storage.get('accessibility')

        if (first !== undefined) {
            $('#firstLoginContent').addClass('d-none')
            Blinder.accessibility = first
            initialize()
            return false;
        }

        $('#firstLoginContent').removeClass('d-none')
        $('#firstLoginContent h3:eq(0)').fadeIn('slow').removeClass('d-none')
        googleJacu = true
        return true;
    }

    $('#firstLoginContent').on('click', function () {
        if(posAudicaoPrimeiroLogin) {
            Eloquent.stopListenning(text => {
                const acessibilidade = text.toLowerCase() == 'sim' ? true : false
                Blinder.accessibility = acessibilidade
                Storage.save('accessibility', acessibilidade)
                $('#firstLoginContent').fadeOut('slow')

                if(acessibilidade) {
                    const text = 'Toda a aplicação funciona da mesma forma.' +
                        'Clique para te ouvirmos.' +
                        'Diga o que quer.' +
                        'E clique novamente para executarmos o que foi pedido.' +
                        'Existe sempre o comando "Opções", para listar os outros comandos de fala disponíveis.' +
                        'Você pode começar testando-o, clique na tela para te ouvirmos, diga "Opções" e clique novamente para executarmos o comando.';
                    Eloquent.speakText(text)
                    initialize()
                } else {
                    initialize()
                }
                posAudicaoPrimeiroLogin = false
            })
        }

        if(ouvirPrimeiroLogin) {
            Eloquent.startListenning()
            ouvirPrimeiroLogin = false
            posAudicaoPrimeiroLogin = true
        }

        if (googleJacu) {
            $('#firstLoginContent h3:eq(1)').fadeIn('slow').removeClass('d-none')
            Eloquent.speak('Deseja manter o controle de voz ativo ?')

            setTimeout(() => {
                $('#firstLoginContent h3:eq(2)').fadeIn('slow').removeClass('d-none')
            }, 3000)

            Eloquent.speak('Clique para o começarmos a te ouvir. Depois responda sim ou não e clique novamente para continuar.')

            setTimeout(() => {
                $('#firstLoginContent h3:eq(3)').fadeIn('slow').removeClass('d-none')
            }, 5500)

            googleJacu = false
            ouvirPrimeiroLogin = true
        }
    })

    $('#loginText').on('changed', function () {
        const value = $(this).val()
        $(this).val(value.replaceAll(' ', ''))
    })

    $('#senhaText').on('changed', function () {
        const value = $(this).val()
        $(this).val(value.replaceAll(' ', ''))
    })

    $('#cadastrarLink').on('click', function () {
        View.tradeView('cadastroView');
    });

    $('#esqueciSenhaLink').on('click', function () {
        View.tradeView('esqueciView');
    });

    $('.linkVoltarLogin').on('click', function () {
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

            if (Array.isArray(response))
                speak = response.mensagem.join('<br/>')

            visible.comunicate(speak, type)

            if (type !== 'success')
                return false;

            return logar(request.emailUsuario, request.senhaUsuario, false)
        });
    });

    $('#btnEntrar').on('click', function () {
        logar($('#loginText').val(), $('#senhaText').val())
    });
})


