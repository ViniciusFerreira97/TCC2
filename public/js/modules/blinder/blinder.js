import Keeper from "./blinderKeeper.js";
import Eloquent from "./eloquent.js";
import storage from "../storage/storage.js";

export default class blinder {

    static tagClass = 'blinderItem';
    static accessibility = false;
    static enabled = false;

    static blinderActions = [
        'check', 'click', 'insert', 'message'
    ];

    static globalComponents = {
        'Opções': 'readComponents',
        'Comandos': 'readComponents',
    };

    static registerComponent(query) {
        let elements = blinder.findSelfComponent(query);
        if (this.components == undefined)
            this.components = {};
        if(this.temporaryKeys == undefined)
            this.temporaryKeys = {};
        elements.each(function () {
            let binderList = $(this);
            let binderItems = binderList.find('item');
            let key = binderList.attr('id');
            if (key == undefined || key == '')
                return false;

            binderItems.each(function () {
                let key = $(this).closest('.' + blinder.tagClass).attr('id');
                let item = $(this);
                if(blinder.temporaryKeys[key] === undefined)
                    blinder.temporaryKeys[key] = [];
                blinder.temporaryKeys[key].push(
                    {
                        'readable': item.attr('name'),
                        'action': item.attr('action'),
                        'value': item.attr('value'),
                        'talk': item.attr('talk'),
                        'pre-talk': item.attr('pre-talk'),
                        'target': item.attr('target'),
                        'alt': item.attr('alt'),
                        'synonym': item.attr('synonym'),
                    }
                );
                blinder.components[item.attr('name')] = {
                    'readable': item.attr('name'),
                    'action': item.attr('action'),
                    'value': item.attr('value'),
                    'talk': item.attr('talk'),
                    'pre-talk': item.attr('pre-talk'),
                    'target': item.attr('target'),
                    'alt': item.attr('alt'),
                    'synonym': item.attr('synonym'),
                }
            });
        });
        blinder.save();
    }

    static save() {
        for (let i in blinder.temporaryKeys) {
            Keeper.write(i, blinder.temporaryKeys[i]);
        }
        return blinder;
    }

    static reset() {
        Keeper.rewrite();
    }

    static load(item = undefined) {
        blinder.components = [];
        let items = Keeper.read(item);
        for(let i in items){
            let inside = items[i];
            for(let j in inside){
                blinder.components[inside[j].readable] = {
                    'callback': inside[j].callback,
                }
            }
        }
        return blinder;
    }

    static getComponents(item = undefined) {
        if (item != undefined)
            return blinder.components[item];
        return blinder.components;
    }

    static eraseComponent(query) {
        let elements = blinder.findSelfComponent(query);
        elements.each(function () {
            let key = $(this).attr('id');
            if (blinder.temporaryKeys != undefined && blinder.temporaryKeys[key] != undefined) {
                blinder.temporaryKeys[key].map((item) => {
                    const read = item.readable
                    blinder.components[read] = undefined;
                })
                blinder.temporaryKeys[key] = undefined;
                Keeper.erase(key);
            }
        });

        return blinder
    }

    static findSelfComponent(element) {
        if (element instanceof jQuery)
            return element.find('.' + blinder.tagClass);
        else
            return $(element).find('.' + blinder.tagClass);
    }

    static callback(e) {
        e.stopPropagation();
        e.preventDefault();
        if (Eloquent.listenning) {
            Eloquent.stopListenning(function (text) {
                blinder.processEloquent(text);
            });
        } else {
            Eloquent.startListenning();
        }
    }

    static handle() {
        if(blinder.components === undefined){
            blinder.reset();
            blinder.accessibility = storage.get('accessibility')
        }
        if (blinder.accessibility && !blinder.enabled) {
            document.addEventListener("click", blinder.callback, true);
        } else if (!blinder.accessibility) {
            document.removeEventListener('click', blinder.callback, true);
        }
    }

    static processEloquent(text) {
        for(let i in blinder.globalComponents){
            if(text.toLowerCase() == i.toLowerCase()){
                return blinder[blinder.globalComponents[i]]();
            }
        }
        let pretext = text.split(' ')[0].toLowerCase();
        let postext = text.replace(pretext+' ','').toLowerCase();
        for(let i in blinder.components){
            if(blinder.components[i] == undefined)
                continue

            let synonym = undefined;

            if(blinder.components[i].synonym != undefined)
                synonym = blinder.components[i].synonym.toLowerCase();

            if(i.toLowerCase() == text || synonym == text) {
                blinder.handleComponent(i)
                return;
            }

            if(pretext == i.toLowerCase() || synonym == pretext){
                blinder.handleComponent(i, postext)
                return;
            }
        }

        return blinder.itemNotFound();
    }

    static handleComponent(i, postext = null){
        if(blinder.components[i]['pre-talk'] !== undefined){
            Eloquent.speak(blinder.components[i]['pre-talk']);
        }
        let action = blinder.components[i].action.toLowerCase();
        if(blinder.blinderActions.includes(action)){
            let target = blinder.components[i].target;
            switch (action) {
                case 'click':
                    $(target).trigger('click');
                    break;
                case 'insert':
                    $(target).val(postext).focus().trigger('changed');
                    break;
                case 'check':
                    $(target).prop('checked', blinder.components[i].value == 'true').trigger('changed')
                    break;
            }
            Eloquent.stopListenning(null)
        }
        if(blinder.components[i] && blinder.components[i].talk !== undefined && postext !== null){
            const speaking = blinder.components[i].talk.replaceAll('[[talk]]', postext)
            Eloquent.speak(speaking);
        }
    }

    static itemNotFound(){
        Eloquent.speak('Desculpe, não consegui encontrar o comando.');
        return blinder;
    }

    static readComponents(){
        if(Object.keys(blinder.components).length) {
            Eloquent.speak('São opções de comando:');
            for(let i in blinder.components){
                if(blinder.components[i] === undefined)
                    continue

                Eloquent.speak(i);

                if(blinder.components[i].alt != undefined)
                    Eloquent.speak(blinder.components[i].alt);
            }
        } else {
            Eloquent.speak('Sem opções de comando.');
        }
        return blinder;
    }
}
