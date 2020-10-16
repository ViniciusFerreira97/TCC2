import View from "../modules/view.js";

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
    });

    $('#tradeProcurar').on('click', function () {
        View.tradeView('procurarView');
    });
}
