import Storage from "../modules/storage/storage.js";

export default function () {
    $('#btnSair').on('click', function () {
        Storage.delete('user')
        location.href = '/html/login.html'
    })
}
