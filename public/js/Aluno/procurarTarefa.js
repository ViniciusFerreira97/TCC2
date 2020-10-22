import Ajax from "../modules/ajax.js";
import Storage from "../modules/storage/storage.js";
import visible from "../modules/visible.js";
import format from "../modules/format.js";
import blinder from "../modules/blinder/blinder.js";

export default function () {
    $('#btnPesquisarTarefa').on('click', function () {
        const codigo = $('#codigoTarefaTxt').val()
        Ajax.setType('GET').setUrl('atividade/procurar/' + codigo)
            .send(response => {
                if(response.codigo === 200) {
                    $('#procurarViewBlinder').append('<item name="Adicionar Atividade" action="click" target="#btnAdicionarTarefa"></item>')
                    blinder.eraseComponent('#procurarView').registerComponent('#procurarView')

                    $('#tarefaNaoEncontradaPesquisa').hide()
                    const data = format.data(response.mensagem.data_maxima)
                    $('#criadorTarefaPesquisada').html('Marcus da Silva')
                    $('#dataTarefaPesquisada').html(data)
                    $('#tituloTarefaPesquisada').html(response.mensagem.titulo)
                    $('#tarefaProcurada').attr('tarefa', codigo)
                    visible.load('tarefaProcurada')
                    let text = 'Titulo da tarefa: ' + response.mensagem.titulo
                    text += '. Professor: Marcus da Silva'
                    text += '. Data de expiração: '+data
                    if(blinder.accessibility)
                        visible.comunicate(text)
                } else {
                    visible.comunicate('Tarefa não encontrada.','#tarefaNaoEncontradaPesquisa')
                }
            })
    })

    $('#btnAdicionarTarefa').on("click", function () {
        const user = Storage.get('user')
        const attributes = {
            'tarefa': $('#tarefaProcurada').attr('tarefa'),
            'codigoUsuario': user.codigoUsuario
        }

        Ajax.setUrl('usuario/adicionar/tarefa').setAttributes(attributes)
            .send(response => {
                if(response.codigo === 200) {
                    if(user.tarefas === undefined)
                        user.tarefas = []

                    user.tarefas.push(response.mensagem)
                    Storage.save('user', user)

                    visible.comunicate('Tarefa adicionada.')
                    visible.retain('tarefaProcurada')
                }
        });
    });
}
