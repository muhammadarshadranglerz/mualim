<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\sendMail;
use App\Models\User;
use App\Mail\SendContact;
use Mail;
use Illuminate\Support\Facades\Artisan;
class testController extends Controller
{
    //


    public function send(){
        $message = "there is no reason to ask reason";
        $detail = "arshadfaarsi13@gmail.com";
       $detail1 = User::pluck('email');
        // Mail::to($email)->send(new SendContact());
        foreach ($detail1 as  $value) {
            # code...
            sendMail::dispatch($detail);
        }

        return "yes its send successfully";
    }
}
