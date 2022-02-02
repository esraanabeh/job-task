<?php

use App\Models\Guest;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;

function api_response($data = null, $message = "", $status = "success")
{
    
    $response = [
        'status' => $status ? true : false,
        'message' => $message,
        'data' => $data,
    ];
    try {
        if ($data) {
            $pagination = api_model_set_pagenation($data);
            if ($pagination) {
                $response['pagination'] = $pagination;
            } else {
                foreach ($data as $key => $row) {
                    if (is_string($key)) {
                        $pagination = api_model_set_pagenation($row);
                        if ($pagination) {
                            $response['pagination'] = $pagination;
                            break;
                        }
                    }
                }
            }
        }
    } catch (\Throwable $th) {
        //throw $th;
    }
    return response()->json($response);
}



if (!function_exists('api_model_set_pagenation')) {

    function api_model_set_pagenation($model)
    {
        if (is_object($model) && count((array) $model)) {
            try {
                $pagnation['total'] = $model->total();
                $pagnation['lastPage'] = $model->lastPage();
                $pagnation['perPage'] = $model->perPage();
                $pagnation['currentPage'] = $model->currentPage();
                return $pagnation;
            } catch (\Exception$e) {
            }
        }
        return null;
    }
}
function current_user()
{
    $user = auth('api')->user();
    $guest = null;
    if ($token = request()->header('FbToken')) {
        $guest = Guest::firstOrCreate(['token' => $token]);
    }
    if ($guest && $user) {
        $guest->cart()->update(['user_id' => $user->id]);
    }
    if (!$user && !$guest) {
        return api_response(null, __('Header token is required'), 0);
    }
    return $user ?? $guest;
}
