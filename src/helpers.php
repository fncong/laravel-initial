<?php
if (!function_exists('success')) {
    function success($msg = '', $data = [])
    {
        return response()->json([
            'code' => 1,
            'message' => $msg,
            'data' => $data
        ]);
    }
}

if (!function_exists('failure')) {
    function failure($msg = '', $data = [], $code = 0)
    {
        return response()->json([
            'code' => $code,
            'message' => $msg,
            'data' => $data
        ]);
    }
}
if (!function_exists('uniqueOrder')) {
    function uniqueOrder($prefix = '')
    {
        return $prefix . date('YmdHis') . random_int(1000, 9999);
    }
}

