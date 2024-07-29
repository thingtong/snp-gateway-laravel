<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Log;

trait UseResponse
{
    public static function ok($data = null, $message = 'OK', $code = 200)
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($response, $code);
    }

    public static function error($error = null, $message = 'Fail', $code = 500)
    {
        $response = [
            'success' => false,
            'message' => $message,
            'data' => $error,
        ];

        return response()->json($response, $code);
    }

    public static function rollBack($message, $exception)
    {
        DB::rollBack();
        Log::info($exception);

        return self::error($exception->getMessage(), $message);
    }
}
