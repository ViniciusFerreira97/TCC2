import View from '/js/modules/view.js';
import Eloquent from "/js/modules/blinder/eloquent.js";
import Storage from "../modules/storage/storage.js";
import Blinder from "../modules/blinder/blinder.js";

import Menu from './menu.js';
import listaTarefas from "./listaTarefas.js";
import procurarTarefa from "./procurarTarefa.js";
import User from "./user.js";

const views = [
    'homeView', 'userView', 'atividadesView', 'procurarView'
]

const menuView = {
    homeView: 'tradeHome',
    userView: 'tradeUser',
    atividadesView: 'tradeAtividade',
    procurarView: 'tradeProcurar',
}

$(document).ready(function (){
    Blinder.handle()

    Menu()
    listaTarefas()
    procurarTarefa()
    User()

    const view = Storage.get('view')
    const viewAble = views.includes(view) ? view : 'homeView'
    $('#' + menuView[viewAble]).click()

    $('.userName').html(Storage.get('user').nomeUsuario)

    $('#procurarAtividadeAtalho').on('click',function () {
        $('#tradeProcurar').click()
    })

    $('#historicoAtividadesAtalho').on('click',function () {
        $('#tradeAtividade').click()
    })
});
