import Storage from "../modules/storage/storage.js";
import visible from "../modules/visible.js";

export default function () {

    $('#tradeAtividade').on('click',function () {
        const user = Storage.get('user')
        $('#listaTarefas').empty()
        if(user.tarefas !== undefined) {
            user.tarefas.map(item => {
                criaListItem(item)
            })

            visible.retain('listaTarefasVazio');
        } else {
            visible.load('listaTarefasVazio');
        }
    })

    function criaListItem (item) {
        let html = '<li class="list-group-item">';

        switch (item.atividade.status) {
            case 1:
                html += '<i class="fas fa-spinner text-warning mr-3"></i>'
                break;
            case 2:
                html += '<i class="fas fa-check text-success mr-3"></i>'
                break;
            default:
                const splitedDate = item.atividade.data_maxima.split('-')
                if(new Date(splitedDate[2], splitedDate[1], splitedDate[0]) > new Date()) {
                    html += '<i class="fas fa-minus text-primary mr-3"></i>'
                } else {
                    html += '<i class="fas fa-minus text-primary mr-3"></i>'
                }
        }
        html += item.atividade.titulo
        html += '</li>'
        $('#listaTarefas').append(html)
    }

}
