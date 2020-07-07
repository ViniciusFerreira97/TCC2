import View from './modules/view.js';
import Eloquent from "./modules/blinder/eloquent.js";

View.load('loginView');

$('#cadastrarLink').on('click',function(){
   View.tradeView('cadastroView');
});

$('#esqueciSenhaLink').on('click',function(){
   View.tradeView('esqueciView');
});

$('.linkVoltarLogin').on('click',function(){
   View.tradeView('loginView');
});

