export default {
    key: 'iVision',
    items: {
        'blinder': 'Dados do blinder (leitor para deficientes visuais)',
        'user': 'Dados do usuario',
        'view': 'View atual em que o usuario esta'
    },

    save (key, item) {
        let storage = localStorage.getItem(this.key)
        storage = this.isJSON(storage) ? JSON.parse(storage) : {}
        storage[key] = item;
        storage = JSON.stringify(storage)
        localStorage.setItem(this.key, storage)

        return this
    },

    delete (key) {
        this.save(key, undefined)

        return this
    },

    get (key) {
        const storage = localStorage.getItem(this.key)

        return this.isJSON(storage) ? JSON.parse(storage)[key] : undefined
    },

    isJSON (item) {
        if(item == undefined)
            return false

        try {
            JSON.parse(item)
        } catch (e) {
            return false
        }

        return true
    }
}
