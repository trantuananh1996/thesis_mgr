<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Support\Facades\Input;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Contracts\Encryption\DecryptException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */

    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     * @return void
     */
    public function report (Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        $e = $this->prepareException($e);

        if ($e instanceof NotFoundHttpException)
        {
            return redirect('/404');
        }
        else if($e instanceof ModelNotFoundException){
            return redirect('/404');
        }
        else if ($e instanceof TokenMismatchException){
            return redirect('/login')->withErrors('Vui lòng đăng nhập lại để tiếp tục');
        } 
        else if ($e instanceof TokenInvalidException){
            $data = Input::json();
            $params = $data->all();

            return response()->json([
                'code'    => $e->getStatusCode(),
                'message' => "Token không hợp lệ",
                'params'  => $params,
                'data'    => ''
            ]);
        } 
        else if ($e instanceof TokenExpiredException){
            $data = Input::json();
            $params = $data->all();

            return response()->json([
                'code'    => $e->getStatusCode(),
                'message' => "Token hết hạn sử dụng",
                'params'  => $params,
                'data'    => ''
            ]);
        } else if ($e instanceof JWTException)
        {
            $data = Input::json();
            $params = $data->all();

            return response()->json([
                'code'    => $e->getStatusCode(),
                'message' => "Lỗi Token của JWT",
                'params'  => $params,
                'data'    => ''
            ]);
        }
        else if($e instanceof DecryptException){
            return redirect('/404');
        }
        return parent::render($request, $e);
    }

    public function unauthenticated($request, $e){
        return redirect('/login');
    }
}
