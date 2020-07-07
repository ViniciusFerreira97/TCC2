import Visible from './visible.js';

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
        return view;
    }

    static tradeView(id){
        view.retain().load(id);
    }

}