export default class blinderKeeper  {

    static key = 'iVisionBlinder';

    static rewrite(value = undefined){
        if(value != undefined || value == 'undefined')
            value = JSON.stringify(value);
        sessionStorage.setItem(blinderKeeper.key,value);
        return blinderKeeper;
    }

    static read(key = undefined){
        let keeper = sessionStorage.getItem(blinderKeeper.key);
        if(keeper != undefined || keeper == 'undefined')
            keeper = JSON.parse(keeper);
        if(key != undefined)
            return keeper[key];
        return keeper;
    }

    static write(key,value){
        let keeper = sessionStorage.getItem(blinderKeeper.key);
        if(keeper == undefined || keeper == 'undefined')
            keeper = {};
        else
            keeper = JSON.parse(keeper);
        keeper[key] = value;
        blinderKeeper.rewrite(keeper);
        return blinderKeeper;
    }

    static erase(key){
        let keeper = JSON.parse(sessionStorage.getItem(blinderKeeper.key));
        if(keeper == undefined || keeper == 'undefined')
            return blinderKeeper;
        keeper[key] = undefined;
        if(keeper.length > 0 || keeper.length == undefined)
            blinderKeeper.rewrite(keeper);
        else
            blinderKeeper.rewrite();
        return blinderKeeper;
    }

}