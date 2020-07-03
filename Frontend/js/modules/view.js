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
            query.hide();
        }
        return view;
    }

    static load(id){
        if($('#'+id).is(':visible') < 0)
            $('#'+id).fadeIn();
        return view;
    }

    static tradeView(id){
        view.retain().load(id);
    }

}