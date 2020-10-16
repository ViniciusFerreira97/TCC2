import Storage from "../modules/storage/storage.js";
import visible from "../modules/visible.js";
import Ajax from "../modules/ajax.js";

export default function () {

    $('#tradeAtividade').on('click',function () {
        const user = Storage.get('user')
        $('#listaTarefas').empty()
        if(user.tarefas !== undefined && user.tarefas.length) {
            user.tarefas.map(item => {
                criaListItem(item)
            })

            visible.retain('listaTarefasVazio');

            loadClickEscolhaTarefa();
        } else {
            visible.load('listaTarefasVazio');
        }
    })

    function criaListItem (item) {
        let html = '<li class="list-group-item" tarefa="'+item.atividade.cd_atividade+'">';

        switch (item.status) {
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

    function loadClickEscolhaTarefa() {
        $('#mainAtividadeView li').on('click', function () {
            const cd_tarefa = $(this).attr('tarefa')
            const atividades = Storage.get('user').tarefas
            let tarefa = '';

            atividades.map(item => {
                if(item.atividade.cd_atividade == cd_tarefa)
                    tarefa = item
            })

            tarefa.status = 1
            Storage.save('tarefaAtual', tarefa)
            loadQuestao(0)
            visible.retain('mainAtividadeView').load('tarefaAtividadeView')
        })
    }

    function loadQuestao(number) {
        let tarefa = Storage.get('tarefaAtual')

        if(number == tarefa.questoes.length)
            return enviarTarefa(tarefa)

        if(number === 0) {
            const atividade = Storage.get('tarefaAtual').atividade
            $('#tarefaAtividadeView .titulo').html(atividade.titulo)
            visible.retain('btnVoltarTarefa')
        } else {
            visible.load('btnVoltarTarefa')

        }
        $('#tarefaAtividadeView .questaoNumero').html(number + 1)
        const questao = tarefa.questoes[number]
        $('#tarefaAtividadeView .textoQuestao').html(questao.enunciado)
        $('#tarefaAtividadeView .letrasQuestao').empty()

        for (let i in questao) {
            if(i.startsWith('alternativa') && questao[i])
                criaOpcaoResposta(i, questao[i], questao)
        }

        tarefa.atual = number
        Storage.save('tarefaAtual', tarefa)
        if($('[name="groupOfDefaultRadios"]:checked').length == 0)
            visible.retain('btnProximaTarefa')
        else
            visible.load('btnProximaTarefa')

        if(number == tarefa.questoes.length - 1)
            $('#btnProximaTarefa').html('Enviar')

        callbackOpcaoClickada()
    }

    function criaOpcaoResposta (alternativa, resposta, questao) {
        const letra = alternativa.substr(alternativa.length - 1)
        let html = ''
        html += '<div class="mt-4">'
        html += '<input type="radio" class="custom-control-input" id="Opcao'+letra+'" name="groupOfDefaultRadios" style="border-radius: 20px" value="'+letra+'"'
        html += questao.resposta === letra ? ' checked' : ''
        html += ' >'
        html += '<label class="custom-control-label" for="Opcao'+letra+'">' + letra +') <span class="ml-3">'+ resposta +'</span></label>'
        html += '</div>'
        $('#tarefaAtividadeView .letrasQuestao').append(html)
    }

    function callbackOpcaoClickada(){
        $('#tarefaAtividadeView .letrasQuestao input').on('click', function() {
            visible.load('btnProximaTarefa')
        })
    }

    $('#btnProximaTarefa').on('click',function () {
        const resposta = $('[name="groupOfDefaultRadios"]:checked').val()
        const tarefa = Storage.get('tarefaAtual')
        tarefa.questoes[tarefa.atual].resposta = resposta
        Storage.save('tarefaAtual', tarefa)
        loadQuestao(tarefa.atual + 1)
    })

    $('#btnVoltarTarefa').on('click', function () {
        const tarefa = Storage.get('tarefaAtual')
        $('#btnProximaTarefa').html('Próxima')
        loadQuestao(tarefa.atual - 1)
    })

    function enviarTarefa(tarefa) {
        let user = Storage.get('user')
        const total = tarefa.questoes.length
        let acertos = 0
        tarefa.questoes.map(item => {
            acertos += item.resposta == item.ds_resposta_correta ? 1 : 0
            item.cd_usuario = user.codigoUsuario
            Ajax.setUrl('usuario/responder/tarefa').setAttributes(item).send()
        })

        const params = {
            cd_atividade: tarefa.atividade.cd_atividade,
            cd_usuario: user.codigoUsuario
        }

        Ajax.setUrl('usuario/finalizar/tarefa').setAttributes(params).send()
        tarefa.status = 2
        tarefa.acertos = acertos
        Storage.save('tarefaAtual', tarefa)

        for(let i in user.tarefas) {
            if(user.tarefas[i].atividade.cd_atividade == tarefa.atividade.cd_atividade) {
                user.tarefas[i] = tarefa
                Storage.save('user', user)
                break;
            }
        }

        $('#resultadoAtividadeView .text-success').html(acertos)
        $('#resultadoAtividadeView .text-danger').html(total - acertos)
        visible.retain('tarefaAtividadeView').load('resultadoAtividadeView')
    }

    $('#btnVoltarInicioTarefa').on('click', function () {
        visible.retain('resultadoAtividadeView').load('mainAtividadeView')
        $('#tradeAtividade').click()
    })

}
