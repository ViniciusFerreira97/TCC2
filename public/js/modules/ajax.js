export default class ajax {

    baseUrl = 'http://localhost:8000/api/';
    clear = true;
    log = true;
    virtualAttributes = [];
    promises = [];
    promisesRequest = [];
    url = '';
    type = 'POST'

    static setUrl(url) {
        const instance = new ajax();
        instance.url = instance.baseUrl + url;
        return instance;
    }

    setUrl(url) {
        this.url = this.baseUrl + url;
        return this;
    }

    static setType (type) {
        const instance = new ajax()
        instance.type = type
        return instance
    }

    setType (type) {
        this.type = type
        return this
    }

    static setAttributes(attributes) {
        const instance = new ajax();
        for (let i in attributes) {
            instance[i] = attributes[i];
            instance.virtualAttributes.push(i);
        }
        return instance;
    }

    setAttributes(attributes) {
        for (let i in attributes) {
            this[i] = attributes[i];
            this.virtualAttributes.push(i);
        }
        return this;
    }

    changeLog(value = true) {
        this.log = value;
        return this;
    }

    changeClear(value = false) {
        const instance = new ajax();
        instance.clear = value;
        return instance;
    }

    send(callback = () => {}, attributes = undefined) {
        if (attributes !== undefined) {
            this.setAttributes(attributes);
        }
        let params = {};
        for (let i in this.virtualAttributes) {
            params[this.virtualAttributes[i]] = this[this.virtualAttributes[i]];
        }
        const selfJs = this;
        $.ajax({
            type: this.type,
            url: this.url + '?XDEBUG_SESSION_START=PHPSTORM',
            data: {
                ...params,
            },
        }).done(function (response) {
            let request = {};
            for (let i in selfJs.virtualAttributes)
                request[selfJs.virtualAttributes[i]] = selfJs[selfJs.virtualAttributes[i]];
            try {
                callback(response, request);
            } catch (e) {
                console.error('Callback Error - ajax');
                if (selfJs.log) {
                    console.error('Response: ' + response);
                    console.error('Error: ' + e);
                }
                callback(response, request);
            }
            if (selfJs.clear) {
                selfJs.clearAttributes();
            }
        });
    }

    clearAttributes() {
        for (let i in this.virtualAttributes)
            this[this.virtualAttributes[i]] = undefined;
        this.virtualAttributes = [];
    }

    promise(attributes = undefined) {
        if (attributes !== undefined) {
            this.setAttributes(attributes);
        }
        let params = {};
        for (let i in this.virtualAttributes) {
            params[this.virtualAttributes[i]] = this[this.virtualAttributes[i]];
        }
        let requested = {
            params
        };
        requested.function = this.function;
        this.promisesRequest.push(requested)
        this.promises.push(
            $.ajax({
                type: this.type,
                url: this.url,
                data: {
                    'function': this.function,
                    'params': params,
                },
            })
        );
        this.clearAttributes();
        return this;
    }

    sendAll(callback = null) {
        const selfJs = this;
        if (callback != null) {
            Promise.all(selfJs.promises).then(function (responses) {
                for (let i in responses) {
                    const response = responses[i];
                    try {
                        responses[i] = response;
                        responses[i].request = selfJs.promisesRequest[i];
                    } catch (e) {
                        console.error('Promise error - ajax');
                        if (selfJs.log) {
                            console.error('Response: ' + responses[i]);
                            console.error('Error: ' + e);
                        }
                        responses[i].request = selfJs.promisesRequest[i];
                    }
                }
                callback(responses);
                selfJs.promisesRequest = [];
                selfJs.promises = [];
            });
        }
        return this;
    }

}
