import Storage from "../storage/storage.js";

export default class blinderKeeper  {

    static key = 'blinder';

    static rewrite(value = undefined){
        Storage.save(blinderKeeper.key, value)

        return blinderKeeper;
    }

    static read(key = undefined){
        let keeper = Storage.get(blinderKeeper.key);

        if(keeper != undefined || keeper == 'undefined')
            keeper = JSON.parse(keeper);

        if(key != undefined)
            return keeper[key];

        return keeper;
    }

    static write(key,value){
        let keeper = Storage.get(blinderKeeper.key)

        if(keeper == undefined || keeper == 'undefined')
            keeper = {};

        keeper[key] = value;
        blinderKeeper.rewrite(keeper);

        return blinderKeeper;
    }

    static erase(key){
        let keeper = Storage.get(blinderKeeper.key)

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
