<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Monolog\Logger;

class RegistrationController extends Controller
{
    protected $negaritManager;
    protected $negarit_api_key;
    /**
     * RegistrationController constructor.
     */
    public function __construct()
    {
        $this->negaritManager = new NegaritSMSController();
        $this->negarit_api_key = "LEpmOLnjkpdny5fmHxRD8GaRpJUgN1T1";
    }

    public function register() {
        $newDataLogger = new Logger('data_logger');
        $post_data = request()->all();
        $newDataLogger->log(Logger::INFO, 'register', ['post_data'=>$post_data]);
        if(isset($post_data['phone']) && isset($post_data['full_name'])) {
            if(strlen($post_data['phone']) >= 9 && strlen($post_data['phone']) <= 12){
                if(str_start($post_data['phone'], '251') || str_start($post_data['phone'], '09') || str_start($post_data['phone'], '9')){
                    $phone = "251".substr($post_data['phone'],strlen($post_data['phone']) - 9, 9);
                    $send_data = array();
                    $send_data['campaign_id'] = 1;
                    $send_data['message'] = "ውድ ".$post_data['full_name']."\n እንኳን ወደ ተስፋ ልዩ ዝግጅት በደህና መጡ!\n በዚህ ልዮ ፕሮግራም ";
                    $send_data['sent_to'] = $phone;
                    $response = $this->negaritManager->sendPostRequest("api_request/sent_message?API_KEY=".$this->negarit_api_key, json_encode($send_data));
                    $response_data = json_decode($response);
                    if(isset($response_data->status)){
                        $newDataLogger->log(Logger::INFO, 'negarit_response', ['negarit_response'=>$response_data]);
                        return response()->json(['status'=>true, 'message'=> "Your Are Successfully Registered", 'error'=>"We have sent you confirmation SMS", "post_data"=>$post_data],200);
                    }else {
                        return response()->json(['status'=>false, 'message'=> "Registration Failed!", 'error'=>"Whoops! Unable To Register You! Try Again Please", "post_data"=>$post_data],200);
                    }
                } else {
                    return response()->json(['status'=>false, 'message'=> "Registration Failed!", 'error'=>"Whoops! Invalid Phone Number Used", "post_data"=>$post_data],200);
                }
            }else {
                return response()->json(['status'=>false, 'message'=> "Registration Failed!", 'error'=>"Whoops! Invalid Phone Number Used", "post_data"=>$post_data],200);
            }
        } else {
            return response()->json(['status'=>false, 'message'=> "Registration Failed!", 'error'=>"Whoops! Something Went Wrong", "post_data"=>$post_data],200);
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
