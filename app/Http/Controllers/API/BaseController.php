<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BaseController extends Controller
{

    public function paginatingResponse($query, $page, $limit)
    {
        $start = ((($page*$limit) - $limit) + 1);
        $count = $query->count();

        $query = $query
            ->offset($start)
            ->limit($limit)
            ->get();

        $result = array();

        array_push($result, $query);
        $result[] = ['total_number' => $count];
        return $result;
    }


    public function sendResponse($result, $message, $code = 200, $status = "success")
    {
        //return Response::json(ResponseUtil::makeResponse($message, $result));
        return [
            'code' => $code,
            'status' => $status,
            'message' => $message,
            'data' => $result,
            'error' => null,
        ];
    }

    public function sendError($error, $message = "Error performing operation", $code = 400)
    {

        $args = func_get_args();
        if (count($args) == 1) {
            $message = $error;
        }
        return response()->json([
            'code' => $code,
            'status' => "error",
            'message' => $message,
            'data' => null,
            'error' => $error,
        ], $code);
    }

    public function sendSuccess($data, $message = "Operation was successful", $code = 200)
    {
        return response()->json([
            'code' => $code,
            'status' => "success",
            'message' => $message,
            'data' => $data,
            'error' => null,
        ], $code);
    }

    public function serverError($message = "Application error", \Exception $exception = null)
    {
        if (!is_null($exception)) {
            logger($exception);
            Log::error("{$exception->getMessage()} on line {$exception->getLine()} in {$exception->getFile()}");
            $message = $exception->getMessage();
        }
        return $this->sendError("error", $message);

    }

    public function generateRef()
    {
        return $ref = time() . rand(10 * 45, 100 * 98);
    }

    public function getUser()
    {
        //return User::where("id", auth("api")->id())->first();
        return request()->user();
    }
}
