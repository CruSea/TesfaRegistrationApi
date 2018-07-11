<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Monolog\Logger;

class RegistrationController extends Controller
{
    public function register() {
        $newDataLogger = new Logger('data_logger');
        $post_data = request()->all();
        print_r($post_data);
        $newDataLogger->log(Logger::INFO, 'register', ['post_data'=>$post_data]);
    }
}
