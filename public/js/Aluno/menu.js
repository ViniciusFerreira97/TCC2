import View from "../modules/view.js";
import eloquent from "../modules/blinder/eloquent.js";

export default function () {

    $('nav a').on('click', function () {
        $('nav').find('.active').not(this).removeClass('active');
        $(this).closest('div.col').addClass('active');
    });

    $('#tradeHome').on('click', function () {
        View.tradeView('homeView');
    });

    $('#tradeUser').on('click', function () {
        View.tradeView('userView');
    });

    $('#tradeAtividade').on('click', function () {
        View.tradeView('atividadesView');
        eloquent.speak('Lista de atividades carregada.')
        $('#listaTarefas li').each(item => {

        })
    });

    $('#tradeProcurar').on('click', function () {
        View.tradeView('procurarView');
        eloquent.speak('Qual atividade iremos realizar ?')
    });
}
