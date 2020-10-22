<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Log;
use Auth;

class ResponseController extends Controller
{
    public function retornaJson($codigo, $mensagem, $log)
    {
        try {
            $data['codigo'] = $codigo;
            $data['mensagem'] = $mensagem;
            if ($log != null) {
                $data['excessao'] = $log;
                Log::error($log);
            }
            return response()->json($data);
        } catch (\Throwable $th) { \Log::error($th); 
            return $th->getMessage();
        }
    }
}
