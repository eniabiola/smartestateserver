<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Throwable;
use App\Traits\ResponseTrait;

class Handler extends ExceptionHandler
{
    use ResponseTrait;

    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {

        if ($exception instanceof \PDOException)
        {
            logger($exception);
            report($exception->getMessage());
            return $this->failedResponse("Error performing operation PD.", 400);
        }
        if ($exception instanceof ModelNotFoundException) {
            report($exception->getMessage());
            return $this->failedResponse("Error retrieving selection MF", 400);
        }
        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->failedResponse("Wrong action for endpoint", 400);
        }
        if ($exception instanceof MethodNotAllowedException) {
            return $this->failedResponse("Wrong action for endpoint", 400);
        }
        if ($exception instanceof ModelNotFoundException) {
            return $this->failedResponse("Error retrieving selection", 400);
        }

/*        if ($exception instanceof NotFoundHttpException) {
            return $this->failedResponse("Resource not available, please, check the endpoint", 400);
        }*/

        if ($exception instanceof ValidationException) {
            foreach ($exception->errors() as $key => $value) {
                $error = $value[0];
            }
            $message = $error ?? "validation error";
            return $this->failedResponse($message, 400);

        }
        return parent::render($request, $exception);
    }
}
