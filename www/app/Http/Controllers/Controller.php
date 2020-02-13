<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param     $data
     * @param int $status
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function apiResponse($data, $status = Response::HTTP_OK)
    {
        $success = $status >= Response::HTTP_BAD_REQUEST ? false : true;
        $data = $status >= Response::HTTP_OK && $status < Response::HTTP_MULTIPLE_CHOICES ? $data : null;
        $response = [
            'success' => $success,
            'data' => $data,
        ];
        if (!$success) {
            $response = array_merge($response, $data);
        }
        return response()->json($response, $status);
    }

    /**
     * @param int        $errorCode
     * @param null|mixed $errorMessage
     *
     * @return array
     */
    protected function errorResponse($errorCode, $errorMessage = null)
    {
        return [
            'errorCode' => $errorCode,
            'errorMessage' => $errorMessage,
        ];
    }
}
