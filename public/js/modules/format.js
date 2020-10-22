export default {

    data (date) {
        const splited = date.split('-');

        return splited[2] + '/' + splited[1] + '/' + splited[0]
    }
}
