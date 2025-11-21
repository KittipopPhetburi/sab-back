<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function ping()
    {
        $dbStatus = false;
        try {
            DB::select('select 1');
            $dbStatus = true;
        } catch (\Exception $e) {
            $dbStatus = false;
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Backend Laravel ทำงานปกติ!',
            'db_connected' => $dbStatus,
        ]);
    }
}
