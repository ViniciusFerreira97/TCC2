<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Log;
use Auth;
use App\Http\Controllers\ResponseController;
use Illuminate\Http\Request;
use App\Models\Atividade;
use App\Models\RlAtividadeQuestao;
use Validator;
use Carbon\Carbon;

class AtividadesController extends Controller
{
    public function cadastrarAtividade(Request $request){
        try {
            $validacao = Validator::make($request->all(), [
                'tituloAtividade' => 'required',
                'descricaoAtividade' => 'required',
                'dataAtividade' => 'required',
                'tempoAtividade' => 'required',
                'codigoUsuario' => 'required'
            ])->setAttributeNames([
                'tituloAtividade' => 'Título da atividade',
                'descricaoAtividade' => 'Descrição da atividade',
                'dataAtividade' => 'Data da atividade',
                'tempoAtividade' => 'Tempo da atividade',
                'codigoUsuario' => 'Código do Usuário'
            ]);
            if ($validacao->fails()) {
                return app(ResponseController::class)->retornaJson(401, $validacao->messages()->all(), false);
            }
            if($request->codigoAtividade != null)
            {
                $atividade = Atividade::find($request->codigoAtividade);
            }
            else
            {
                $atividade = new Atividade;
            }
            $atividade->titulo = $request->tituloAtividade;
            $atividade->descricao = $request->descricaoAtividade;
            $atividade->data_maxima = Carbon::createFromFormat('d/m/Y', $request->dataAtividade)->format('Y-m-d');
            $atividade->tempo = $request->tempoAtividade;
            $atividade->cd_usuario = $request->codigoUsuario;
            $atividade->save();
            return app(ResponseController::class)->retornaJson(200, $atividade, null);
        } catch (\Throwable $th) {
            return app(ResponseController::class)->retornaJson(500, "Erro interno ao processar sua solicitação.", $th->getMessage());
        }
    }

    public function cadastrarQuestao(Request $request){
        try {
            $validacao = Validator::make($request->all(), [
                'codigoAtividade' => 'required',
                'enunciado' => 'required',
                'alternativaA' => 'required',
                'alternativaB' => 'required',
                'alternativaC' => 'required',
                'alternativaD' => 'required',
                'alternativaE' => 'required'
            ])->setAttributeNames([
                'codigoAtividade' => 'Código da Atividade',
                'enunciado' => 'Enuncado da atividade',
                'alternativaA' => 'Alternativa A',
                'alternativaB' => 'Alternativa B',
                'alternativaC' => 'Alternativa C',
                'alternativaD' => 'Alternativa D',
                'alternativaE' => 'Alternativa E',
            ]);
            if ($validacao->fails()) {
                return app(ResponseController::class)->retornaJson(401, $validacao->messages()->all(), false);
            }
            $questao = new RlAtividadeQuestao;
            $questao->enunciado = $request->enunciado;
            $questao->cd_atividade = $request->codigoAtividade;
            $questao->ds_resposta_correta = $request->respostaCorreta;
            $questao->alternativaA = $request->alternativaA;
            $questao->alternativaB = $request->alternativaB;
            $questao->alternativaC = $request->alternativaC;
            $questao->alternativaD = $request->alternativaD;
            $questao->alternativaE = $request->alternativaE;
            $questao->save();
            return app(ResponseController::class)->retornaJson(200, $questao, null);
        } catch (\Throwable $th) {
            return app(ResponseController::class)->retornaJson(500, "Erro interno ao processar sua solicitação.", $th->getMessage());
        }
    }

    public function listarDadosQuestao($codigoQuestao)
    {
        $questao = RlAtividadeQuestao::find($codigoQuestao);
        return app(ResponseController::class)->retornaJson(200, $questao, null);
    }

    public function listarAtividades($codigoUsuario, $codigoAtividade){
        try {
            if(!$codigoUsuario)
            {
                return app(ResponseController::class)->retornaJson(500, "Erro interno ao processar sua solicitação.", null);
            }
            if($codigoAtividade != 0)
            {
                $atividades = Atividade::where('cd_atividade', $codigoAtividade)->where('cd_usuario',$codigoUsuario)->get();
            }
            else
            {
                $atividades = Atividade::where('cd_usuario',$codigoUsuario)->get();
            }
            return app(ResponseController::class)->retornaJson(200, $atividades, null);
        } catch (\Throwable $th) {
            return app(ResponseController::class)->retornaJson(500, "Erro interno ao processar sua solicitação.", $th->getMessage());
        }
    }

    public function editarAtividade(Request $request){
        try {
            $validacao = Validator::make($request->all(), [
                'codigoAtividade' => 'required',
                'tituloAtividade' => 'required',
                'descricaoAtividade' => 'required',
                'permitirTempo' => 'required'
            ])->setAttributeNames([
                'codigoAtividade' => 'Código da atividade',
                'tituloAtividade' => 'Título da atividade',
                'descricaoAtividade' => 'Descrição da atividade',
                'permitirTempo' => 'Permitir Tempo'
            ]);
            if ($validacao->fails()) {
                return app(ResponseController::class)->retornaJson(401, $validacao->messages()->all(), false);
            }
            $atividade = Atividade::find($request->codigoAtividade);
            $atividade->titulo = $request->tituloAtividade;
            $atividade->descricao = $request->descricaoAtividade;
            $atividade->permitir_tempo = $request->permitirTempo;
            if($request->permitir_tempo == 1)
            {
                if($request->tempoRealizacao && $request->tempoRealizacao != null)
                {
                    $atividade->tempo = $request->tempoRealizacao;
                }
                else
                {
                    return app(ResponseController::class)->retornaJson(404, 'O tempo de realização é inválido.', null);
                }
            }
            $atividade->save();
            return app(ResponseController::class)->retornaJson(200, 'Atividade cadastrada com sucesso.', null);
        } catch (\Throwable $th) {
            return app(ResponseController::class)->retornaJson(500, "Erro interno ao processar sua solicitação.", $th->getMessage());
        }
    }

    public function apagarAtividade(Request $request){
        try {
            $validacao = Validator::make($request->all(), [
                'codigoAtividade' => 'required'
            ])->setAttributeNames([
                'codigoAtividade' => 'Código do atividade'          
            ]);
            if ($validacao->fails()) {
                return app(ResponseController::class)->retornaJson(401, $validacao->messages()->all(), false);
            }
            $atividade = Atividade::where('cd_atividade', $request->codigoAtividade)->delete();
            return app(ResponseController::class)->retornaJson(200, 'Atividade apagada com sucesso.', null);
        } catch (\Throwable $th) {
            return app(ResponseController::class)->retornaJson(500, "Erro interno ao processar sua solicitação.", $th->getMessage());
        }
    }


}
