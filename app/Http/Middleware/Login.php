<?php

namespace App\Http\Middleware;

use Closure;

class Login
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (session()->has('login') == false || !session('login')) {
            //cria uma msg vazia ou null, nenhuma msg de aviso é criada
                if(session()->has('msg') == false){
                    session(['msg' => [
                        'tipo' => 'alerta',
                        'texto' => 'Realize o login para ter acesso ao sistema!'
                    ]]);
                }
            //
            return redirect()->route('inicio');
        }
        //caso sucesso retorne, caso nao sucesso retorne qualquer coisa diferente do codigo abaixo
        return $next($request);
    }
}
