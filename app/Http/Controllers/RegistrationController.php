<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Monolog\Logger;

class RegistrationController extends Controller
{
    protected $negaritManager;
    /**
     * RegistrationController constructor.
     */
    public function __construct()
    {
        $this->negaritManager = new NegaritSMSController();
    }

    public function register() {
        $newDataLogger = new Logger('data_logger');
        $post_data = request()->all();
        $newDataLogger->log(Logger::INFO, 'register', ['post_data'=>$post_data]);
        if(isset($post_data['phone']) && isset($post_data['full_name'])) {
            $send_data = array();
            $send_data['campaign_id'] = 1;
            $send_data['message'] = "Dear ".$post_data['full_name']."\n Welcome To Tesfa Conference!\n You are Registered For The Event";
            $send_data['sent_to'] = $post_data['phone'];
            $response = $this->negaritManager->sendPostRequest("api_request/sent_message?API_KEY=ZbaFOaXNUocbBpFBzJTqVg5g1gLGZRd7", $send_data);
            return response()->json(['status'=>true, 'message'=> "Your Are Successfully Registered", 'error'=>"We have sent you confirmation SMS", "post_data"=>$post_data],200);
        } else {

        }
    }

    public function wpregister() {
        $newDataLoggerwp = new Logger('data_logger_wp');
        $post_data_wp = request()->all();
        $newDataLoggerwp->log(Logger::INFO, 'register', ['post_data'=>$post_data_wp]);
//        if(isset($post_data['phone']) && isset($post_data['full_name'])) {
//            $send_data = array();
//            $send_data['campaign_id'] = 1;
//            $send_data['message'] = "Dear ".$post_data['full_name']."\n Welcome To Tesfa Conference!\n You are Registered For The Event";
//            $send_data['sent_to'] = $post_data['phone'];
//            $response = $this->negaritManager->sendPostRequest("api_request/sent_message?API_KEY=ZbaFOaXNUocbBpFBzJTqVg5g1gLGZRd7", $send_data);
//            return response()->json(['status'=>true, 'message'=> "Your Are Successfully Registered", 'error'=>"We have sent you confirmation SMS", "post_data"=>$post_data],200);
//        } else {
//
//        }
    }
}
