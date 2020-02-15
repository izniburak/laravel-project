<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class MainController extends Controller
{
    /**
     * Healt Check
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function healtCheck()
    {
        return $this->apiResponse([], Response::HTTP_OK);
    }

    /**
     * Application Information
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function info()
    {
        $system = config('system');
        $response = [
            'version' => $system['version'],
            'update'  => $system['update'],
            'langs'   => $system['langs'],
        ];
        return $this->apiResponse($response, Response::HTTP_OK);
    }
}
