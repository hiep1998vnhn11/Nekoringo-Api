<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class AppBaseController extends Controller
{

    /**
     * Send respond Success to Client
     *
     * @param object $data
     * @param string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendRespondSuccess($data, $message)
    {
        return response()->json([
            'status'  => 'success',
            'current' => Carbon::now()->toDateTimeString(),
            'message' => $message,
            'data'    => $data
        ]);
    }

    /**
     * Send Respond Error to Client.
     *
     * @param object $data
     * @param string $message
     * @param int $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendRespondError($data, $message, $code = 404)
    {
        return response()->json([
            'status'  => 'error',
            'current' => Carbon::now()->toDateTimeString(),
            'message' => $message,
            'data'    => $data
        ], $code);
    }
}
