<?php

namespace App\Traits;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

trait ApiResponser{

    public function  set_response($data, $status_code, $status)
    {
        $resData = response(json_encode(
                [
                    'data'          =>  $data,
                    'status'        =>  $status,
                    'code'          =>  $status_code,
                ]
        ), 200)
        ->header('Content-Type', 'application/json');

        $data = [];

        return $resData;
    }

}
