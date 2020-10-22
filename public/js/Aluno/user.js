import Storage from "../modules/storage/storage.js";
import Blinder from "../modules/blinder/blinder.js";

export default function () {
    $('#btnSair').on('click', function () {
        Storage.delete('user')
        location.href = '/login'
    })

    $('#tradeUser').on('click', function () {
        const active = Storage.get('accessibility');

        $("#checkAcessibilidade").prop( "checked", active );
    })

    $('#checkAcessibilidade').on('click changed', function () {
        const accessibility = $(this).is(':checked')
        Blinder.accessibility = accessibility
        Storage.save('accessibility', accessibility)
        Blinder.handle()
    })
}
