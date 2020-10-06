
export default class ajax  {

    static baseUrl = 'http://localhost:8000/api/';
    static clear = true;
    static virtualAttributes = [];

    static setAttributes(attributes){
        for(let i in attributes){
            this[i] = attributes[i];
            this.virtualAttributes.push(i);
        }
        return ajax;
    }

    static setUrl(url,baseUrl = ajax.baseUrl){
        this.url = baseUrl+url;
        return ajax;
    }

    static changeClear(value = false){
        this.clear = value;
    }

    static send(callback = function(){}, url = undefined, attributes = undefined){
        if(url !== undefined){
            ajax.setUrl(url);
        }
        if(attributes !== undefined){
            ajax.setAttributes(attributes);
        }
        $.ajax({
            type: "POST",
            url: ajax.url,
            data: ajax,
        }).done(function (response) {
            for(let i in ajax.virtualAttributes)
                this[ajax.virtualAttributes[i]] = ajax[ajax.virtualAttributes[i]];
            if(response.codigo == 200)
            {
                callback(response);
            }
            else{
                console.log(response);
            }
            if(ajax.clear){
                for(let i in ajax.virtualAttributes)
                    ajax[ajax.virtualAttributes[i]] = undefined;
                ajax.virtualAttributes = [];
            }
        });
    }

}