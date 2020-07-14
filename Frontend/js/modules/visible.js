import blinder from "./blinder/blinder.js";
import eloquent from "./blinder/eloquent.js";

export default class visible  {

    static hide = 'hide';
    static show = 'fadeIn';
    static classHide = 'd-none';

    static load(item){
        let elementToRegister = '';
        if(item instanceof Element) {
            $(item).fadeIn().removeClass(visible.classHide);
            elementToRegister = item;
        }
        else if(item instanceof jQuery) {
            item.fadeIn().removeClass(visible.classHide);
            elementToRegister = item;
        }
        else {
            $('#' + item).fadeIn().removeClass(visible.classHide);
            elementToRegister = '#'+item;
        }

        blinder.registerComponent(elementToRegister);

        return visible;
    }

    static retain(item){
        let elementToErase = '';
        if(item instanceof Element || item instanceof jQuery){
            item.hide();
            elementToErase = item;
        }else{
            $('#'+item).hide();
            elementToErase = '#'+item;
        }

        blinder.eraseComponent(elementToErase);

        return visible;
    }

    static comunicate(mensage,type = 'success'){
        if(blinder.accessibility){
            eloquent.speakText(mensage);
        }else{
            $('#alert-'+type+' .modal-body').html(mensage);
            $('#alert-'+type).modal('show');
            setTimeout(function(){
                $('#alert-'+type).modal('hide');
            },1500);
        }
    }

}