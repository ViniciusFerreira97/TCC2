import Keeper from "./blinderKeeper.js";
import Eloquent from "./eloquent.js";
import eloquent from "./eloquent.js";

export default class blinder {

    static tagClass = 'blinderItem';
    static accessibility = false;
    static enabled = false;

    static blinderActions = [
        'click', 'insert', 'message'
    ];

    static globalComponents = {
        'Opções': 'readComponents',
    };

    static reset() {
        Keeper.rewrite();
    }

    static save() {
        for (let i in blinder.components) {
            Keeper.write(i, blinder.components[i]);
        }
        return blinder;
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

    static registerComponent(query) {
        let elements = blinder.findSelfComponent(query);
        if (this.components == undefined) {
            this.components = {};
        }
        elements.each(function () {
            let binderList = $(this);
            let binderItems = binderList.find('item');
            let key = binderList.attr('id');
            if (key == undefined || key == '')
                return false;
            binderItems.each(function () {
                let key = $(this).closest('.' + blinder.tagClass).attr('id');
                let item = $(this);
                if(blinder.components[key] === undefined)
                    blinder.components[key] = [];
                blinder.components[key].push(
                    {
                        'readable': item.attr('name'),
                        'callback': item.attr('callback'),
                        'value': item.attr('value'),
                    }
                );
            });
        });
        blinder.save();
    }

    static eraseComponent(query) {
        let elements = blinder.findSelfComponent(query);
        elements.each(function () {
            let key = $(this).attr('id');
            if (blinder.components != undefined && blinder.components[key] != undefined) {
                blinder.components[key] = undefined;
                Keeper.erase(key);
            }
        });
    }

    static findSelfComponent(element) {
        if (element instanceof jQuery)
            return element.find('.' + blinder.tagClass);
        else
            return $(element).find('.' + blinder.tagClass);
    }

    static handle() {
        let callback = function (e) {
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
        if (blinder.accessibility && !blinder.enabled) {
            document.addEventListener("click", callback, true);
        } else if (!blinder.accessibility) {
            document.removeEventListener('click', callback, true);
        }
    }

    static processEloquent(text) {
        for(let i in blinder.globalComponents){
            if(text.toLowerCase == i.toLowerCase){
                blinder[blinder.globalComponents[i]]();
            }
        }
    }

    static readComponents(){
        blinder.load();
        Eloquent.speak('São opções de comando:');
        for(let i in blinder.components){
            Eloquent.speak(i);
        }
        return;
    }
}