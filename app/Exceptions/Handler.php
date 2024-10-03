<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;

class Handler extends ExceptionHandler
{
    /**
     * Um array de tipos de exceções que são reportadas.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * Um array de tipos de exceções que não são convertidas em resposta HTTP.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Registra as exceções.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // Registrar a exceção
        \Log::error('Exception caught: ', [
            'exception' => $exception,
            'request' => $request->all()
        ]);

        // Verificar se o pedido espera JSON
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Ocorreu um erro no servidor.',
                'error' => $exception->getMessage()
            ], 500);
        }

        return parent::render($request, $exception);
    }
}
