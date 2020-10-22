import Visible from './visible.js';
import Storage from "./storage/storage.js";

export default class view  {

    static identifier = 'section.view';

    static retain(id = undefined, exception = []){
        if(id !== undefined)
            $('#'+id).hide();
        else {
            let query = $(view.identifier);
            for(let i in exception){
                query.not('#'+exception[i]);
            }
            Visible.retain(query);
        }
        return view;
    }

    static load(id){
        Visible.load(id);
        Storage.save('view', id)
        return view;
    }

    static tradeView(id){
        view.retain().load(id);
    }

}
