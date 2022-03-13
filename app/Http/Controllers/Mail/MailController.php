<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;

class MailController extends Controller
{
    public function basic_email() {
        $data = array('name'=>"Virat Gandhi");
     
        Mail::send('mail.mail', $data, function($message) {
           $message->to('mwaqasiu@gmail.com', 'Tutorials Point')->subject
              ('Laravel Basic Testing Mail');
           $message->from('no-reply@nyayomat.com','Virat Gandhi');
        });
        echo "Basic Email Sent. Check your inbox.";
     }
}
