<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NegaritSMSController extends Controller
{
    protected $negarit_api_url = "http://api.negarit.net/api/";

    /**
     * NegaritSMSController constructor.
     */
    public function __construct()
    {
        $this->negarit_api_url = "http://api.negarit.net/api/";
//        $this->negarit_api_url = "http://127.0.0.1:4444/api/";
    }

    public function sendPostRequest($request_route, $send_post_data){
        $ch = curl_init($this->negarit_api_url.$request_route);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $send_post_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}
