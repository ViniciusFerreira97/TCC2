<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Atividade;
use App\Models\RlAtividadeQuestao;
use App\Models\RlUsuarioAtividade;
use App\Models\RlUsuarioQuestao;
use App\Models\TipoCompromisso;
use Log;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Usuarios;
use Hash;
use App\Http\Controllers\ResponseController;
use DB;


class UsuariosController extends Controller
{
    public function cadastrarUsuario(Request $request){
        try {
            $validacao = Validator::make($request->all(), [
                'nomeUsuario' => 'required',
                'emailUsuario' => 'required',
                'senhaUsuario' => 'required',
                'codigoTipoUsuario' => 'required'
            ])->setAttributeNames([
                'nomeUsuario' => 'Nome do Usuário',
                'emailUsuario' => 'Email do usuário',
                'senhaUsuario' => 'Senha do Usuário',
                'codigoTipoUsuario' => 'Tipo Usuário'
            ]);
            if ($validacao->fails()) {
                return app(ResponseController::class)->retornaJson(401, $validacao->messages()->all(), false);
            }
            $usuario = new Usuarios;
            $usuario->nm_usuario = $request->nomeUsuario;
            $usuario->email = $request->emailUsuario;
            $usuario->senha = Hash::make($request->senhaUsuario);
            $usuario->cd_tipo_usuario = $request->codigoTipoUsuario;
            $usuario->save();
            return app(ResponseController::class)->retornaJson(200, 'Usuário cadastrado com sucesso.', null);
        } catch (\Throwable $th) {
            return app(ResponseController::class)->retornaJson(500, "Erro interno ao processar sua solicitação.", $th->getMessage());
        }
    }

    public function editarUsuario(Request $request){
        try {
            $validacao = Validator::make($request->all(), [
                'codigoUsuario' => 'required',
                'nomeUsuario' => 'required',
                'senhaUsuario' => 'required'
            ])->setAttributeNames([
                'codigoUsuario' => 'Código Usuário',
                'nomeUsuario' => 'Nome do Usuário',
                'senhaUsuario' => 'Senha do Usuário'
            ]);
            if ($validacao->fails()) {
                return app(ResponseController::class)->retornaJson(401, $validacao->messages()->all(), false);
            }
            $usuario = Usuarios::find($request->codigoUsuario);
            $usuario->nome = $request->nomeUsuario;
            if($request->senhaUsuario != null && $request->senhaUsuario != ''){
                $usuario->senha = Hash::make($request->senhaUsuario);
            }
            $usuario->save();
            return app(ResponseController::class)->retornaJson(200, 'Usuário editado com sucesso.', null);
        } catch (\Throwable $th) {
            return app(ResponseController::class)->retornaJson(500, "Erro interno ao processar sua solicitação.", $th->getMessage());
        }
    }

    public function login(Request $request)
    {
        try {
            $email = $request->email;
            $senha = $request->senha;

            $validacao = Validator::make($request->all(), [
                'email' => 'required',
                'senha' => 'required'
            ])->setAttributeNames([
                'email' => 'Email do Usuário',
                'senha' => 'Senha do usuário'
            ]);
            if ($validacao->fails()) {
                return app(ResponseController::class)->retornaJson(401, $validacao->messages()->all(), false);
            }

            $usuario = Usuarios::where('email', $email)->first();
            if (is_null($usuario)) {
                return app(ResponseController::class)->retornaJson(404, 'Email e/ou senha inválido.', null);
            }
            if (Hash::check($senha, $usuario->senha)  != true) {
                return app(ResponseController::class)->retornaJson(404, 'Email e/ou senha inválido.', null);
            }
            \Session::put('cd_usuario', $usuario->cd_usuario);
            \Session::put('nm_usuario', $usuario->nm_usuario);
            \Session::put('email', $usuario->email);
            \Session::put('cd_tipo_usuario', $usuario->cd_tipo_usuario);

            $rlUsuarioAtividade = new RlUsuarioAtividade();
            $rlAtividades = $rlUsuarioAtividade->where('cd_usuario', $usuario->cd_usuario)->get();
            $userAtividades = [];
            $rlAtividades->each(function($item) use (&$userAtividades) {
                $atividade = new Atividade();
                $rlAtividadeQuestao = new RlAtividadeQuestao();
                $rlAtividadeQuestao->where('cd_atividade', $item->cd_atividade);
                $userAtividades[] = [
                    'atividade' => $atividade->find($item->cd_atividade),
                    'questoes' => $rlAtividadeQuestao->get(),
                ];
            });

            $dados = [];
            $dados['codigoUsuario'] = $usuario->cd_usuario;
            $dados['nomeUsuario'] = $usuario->nm_usuario;
            $dados['codigoTipoUsuario'] = $usuario->cd_tipo_usuario;
            $dados['tarefas'] = $userAtividades;
            return app(ResponseController::class)->retornaJson(200, $dados, null);
        } catch (\Throwable $th) {
            Log::error($th);
            return app(ResponseController::class)->retornaJson(500, "Erro interno ao realizar a autenticação.", $th->getMessage());
        }
    }

    public function procurarTarefa($id){
        $atividade = new Atividade();
        $atividadeEncontrada = $atividade->find($id);

        if(!$atividadeEncontrada) {
            return app(ResponseController::class)->retornaJson(404, 'Atividade invalida.', null);
        }

        return app(ResponseController::class)->retornaJson(200, $atividadeEncontrada, null);
    }

    public function adicionarTarefa(Request $request)
    {
        $atividade = new Atividade();
        $atividadeEncontrada = $atividade->find($request->tarefa);

        if(!$atividadeEncontrada) {
            return app(ResponseController::class)->retornaJson(404, 'Atividade invalida.', null);
        }

        $rl = new RlUsuarioAtividade();
        $rl->cd_usuario = $request->codigoUsuario;
        $rl->cd_atividade = $request->tarefa;
        $rl->tempo_restante = 'aaaa';
        $rl->flg_finalizada = 0;
        $rl->save();

        $questoes = new RlAtividadeQuestao();
        $data = $questoes->where('cd_atividade', $request->tarefa)
            ->get();

        $items = [
            'atividade' => $atividadeEncontrada,
            'questoes' => $data
        ];

        return app(ResponseController::class)->retornaJson(200, $items, null);
    }

    public function responderTarefa(Request $request) {
        $validacao = Validator::make($request->all(), [
            'cd_usuario' => 'required',
            'cd_atividade_questao' => 'required',
            'resposta' => 'required'
        ])->setAttributeNames([
            'cd_usuario' => 'Codigo do usuario',
            'cd_atividade_questao' => 'Codigo da Questao',
            'resposta' => 'Resposta'
        ]);
        if ($validacao->fails()) {
            return app(ResponseController::class)->retornaJson(401, $validacao->messages()->all(), false);
        }

        $rlAtividadeQuestao = new RlAtividadeQuestao();
        $rlAtividadeQuestao = $rlAtividadeQuestao->find($request->cd_atividade_questao);

        $rlUsuarioQuestao = new RlUsuarioQuestao();
        $rlUsuarioQuestao->cd_atividade_questao = $request->cd_atividade_questao;
        $rlUsuarioQuestao->cd_usuario = $request->cd_usuario;
        $rlUsuarioQuestao->resposta = $request->resposta;
        $rlUsuarioQuestao->flg_correto = $request->resposta == $rlAtividadeQuestao->ds_resposta_correta ? '1' : '0';
        $rlUsuarioQuestao->save();

        return $rlUsuarioQuestao;
    }

    public function finalizaTarefa(Request $request){
        $validacao = Validator::make($request->all(), [
            'cd_atividade' => 'required',
            'cd_usuario' => 'required',
        ])->setAttributeNames([
            'cd_atividade' => 'Codigo da Atividade',
            'cd_usuario' => 'Codigo do Usuario',
        ]);
        if ($validacao->fails()) {
            return app(ResponseController::class)->retornaJson(401, $validacao->messages()->all(), false);
        }

        $rlUsuarioAtividade = new RlUsuarioAtividade();
        $rlUsuarioAtividade->flg_finalizada = 1;
        $rlUsuarioAtividade->where('cd_usuario', $request->cd_usuario)
            ->where('cd_atividade', $request->cd_atividade);
        return $rlUsuarioAtividade->update();
    }

    public function listarHomeProfessor($codigoUsuario)
    {
        $data = [];
        $data['contadorAtividades'] = Atividade::where('cd_usuario', $codigoUsuario)->count();
        $data['contadorQuestoes'] = Atividade::join('rl_atividade_questao', 'rl_atividade_questao.cd_atividade', '=', 'tb_atividades.cd_atividade')
                                                ->where('tb_atividades.cd_usuario', $codigoUsuario)->count();
        $data['contadorRespostas'] = Atividade::join('rl_atividade_questao', 'rl_atividade_questao.cd_atividade', '=', 'tb_atividades.cd_atividade')
                                                ->join('rl_usuario_questao', 'rl_usuario_questao.cd_atividade_questao', '=', 'rl_atividade_questao.cd_atividade_questao')
                                                ->where('tb_atividades.cd_usuario', $codigoUsuario)->count();
        $data['contadorProfessores'] = Usuarios::where('cd_tipo_usuario', 2)->count();
        $data['contadorAlunos'] = Usuarios::where('cd_tipo_usuario', 1)->count();
        $errosXacertos = Atividade::select([
            DB::raw('sum(case when rl_usuario_questao.flg_correto = 1 then 1 else 0 end) as acertos'),
            DB::raw('sum(case when rl_usuario_questao.flg_correto != 1 then 1 else 0 end) as erros')
        ])
        ->join('rl_atividade_questao', 'rl_atividade_questao.cd_atividade', '=', 'tb_atividades.cd_atividade')
        ->join('rl_usuario_questao', 'rl_usuario_questao.cd_atividade_questao', '=', 'rl_atividade_questao.cd_atividade_questao')
        ->where('tb_atividades.cd_usuario', $codigoUsuario)->get();
        if(sizeof($errosXacertos) > 0)
        {
            $data['acertosGrafico'] = $errosXacertos[0]->acertos != null ? $errosXacertos[0]->acertos != null : 1 ;
            $data['errosGrafico'] = $errosXacertos[0]->erros != null ? $errosXacertos[0]->erros : 1;
        }
        else
        {
            $data['acertosGrafico'] = 1;
            $data['errosGrafico'] = 1;
        }

        $atividadesRealizadas = Atividade::join('rl_usuario_atividade', 'rl_usuario_atividade.cd_atividade', '=', 'tb_atividades.cd_atividade')
        ->where('tb_atividades.cd_usuario', $codigoUsuario)->distinct()->pluck('tb_atividades.cd_atividade');
        $data['atividadesRealizadasGrafico'] = count($atividadesRealizadas);
        $data['atividadesNaoRealizadasGrafico'] = Atividade::where('cd_usuario', $codigoUsuario)->whereNotIn('cd_atividade', $atividadesRealizadas)->count();
        return app(ResponseController::class)->retornaJson(200, $data, null);
    }
}
