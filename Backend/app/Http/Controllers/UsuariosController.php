<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Log;
use Auth;
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
            $usuario = new Usuario;
            $usuario->nome = $request->nomeUsuario;
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
            $usuario = Usuario::find($request->codigoUsuario);
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

            $usuario = Usuario::where('email', $email)->first();
            if (is_null($usuario)) {
                return app(ResponseController::class)->retornaJson(404, 'Email e/ou senha inválido.', null);
            }
            if (Hash::check($senha, $usuario->senha)  != true) {
                return app(ResponseController::class)->retornaJson(404, 'Email e/ou senha inválido.', null);
            }
            Auth::login($usuario, true);
            //Implementar Session PUT
            $dados = [];
            $dados['codigoUsuario'] = Auth::user()->cd_usuario;
            $dados['nomeUsuario'] = Auth::user()->nome;
            return app(ResponseController::class)->retornaJson(200, $dados, null);
        } catch (\Throwable $th) {
            Log::error($th);
            return app(ResponseController::class)->retornaJson(500, "Erro interno ao realizar a autenticação.", $th->getMessage());
        }
    }
}
