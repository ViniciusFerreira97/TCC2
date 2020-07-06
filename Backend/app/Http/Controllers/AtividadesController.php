<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Log;
use Auth;
use App\Http\Controllers\ResponseController;


class AtividadesController extends Controller
{
    public function cadastrarAtividade(Request $request){
        try {
            $validacao = Validator::make($request->all(), [
                'tituloAtividade' => 'required',
                'descricaoAtividade' => 'required',
                'permitirTempo' => 'required'
            ])->setAttributeNames([
                'tituloAtividade' => 'Título da atividade',
                'descricaoAtividade' => 'Descrição da atividade',
                'permitirTempo' => 'Permitir Tempo'
            ]);
            if ($validacao->fails()) {
                return app(ResponseController::class)->retornaJson(401, $validacao->messages()->all(), false);
            }
            $atividade = new Atividade;
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

    public function cadastrarQuestao(Request $request){
        try {
            $validacao = Validator::make($request->all(), [
                'codigoAtividade' => 'required',
                'enunciado' => 'required',
                'codigoTipoQuestao' => 'required'
            ])->setAttributeNames([
                'codigoAtividade' => 'Código da Atividade',
                'enunciado' => 'Enuncado da atividade',
                'codigoTipoQuestao' => 'Tipo de questão'
            ]);
            if ($validacao->fails()) {
                return app(ResponseController::class)->retornaJson(401, $validacao->messages()->all(), false);
            }
            $atividade = new AtividadeQuestao;
            $atividade->enunciado = $request->enunciado;
            $atividade->codigoTipoQuestao = $request->codigoTipoQuestao;
            $atividade->alternativaA = $request->alternativaA;
            $atividade->alternativaB = $request->alternativaB;
            if($request->permitir_tempo == 2)
            {
                $atividade->alternativaB = $request->alternativaC;
                $atividade->alternativaB = $request->alternativaD;
                $atividade->alternativaB = $request->alternativaE;
            }
            $atividade->save();
            return app(ResponseController::class)->retornaJson(200, 'Questão cadastrada com sucesso.', null);
        } catch (\Throwable $th) {
            return app(ResponseController::class)->retornaJson(500, "Erro interno ao processar sua solicitação.", $th->getMessage());
        }
    }

    public function listarAtividades($codigoAtividade){
        try {
            if($codigoAtividade != 0)
            {
                $atividades = Atividades::where('cd_atividade', $codigoAtividade)->get();
            }
            else
            {
                $atividades = Atividades::get();
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
