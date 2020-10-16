<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Atividade;
use App\Models\RlAtividadeQuestao;
use App\Models\RlUsuarioAtividade;
use App\Models\TipoCompromisso;
use Log;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Usuarios;
use Hash;
use App\Http\Controllers\ResponseController;


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
            'questao' => $data
        ];

        return app(ResponseController::class)->retornaJson(200, $items, null);
    }
}
