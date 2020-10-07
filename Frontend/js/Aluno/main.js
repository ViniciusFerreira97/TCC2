import View from '/js/modules/view.js';
import Eloquent from "/js/modules/blinder/eloquent.js";
import Storage from "../modules/storage/storage.js";

import Menu from './menu.js';
import User from "./user.js";


$(document).ready(function (){
    Menu()
    User()

    const view = Storage.get('view')
    View.tradeView(view ?? 'homeView')

    $('.userName').html(Storage.get('user').nomeUsuario)
});
