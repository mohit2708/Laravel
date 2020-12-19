<?php 

namespace App\Helpers;
use Mail;

class Helper
{
    public static function RegistrationEmail(string $string)
    {    
    	//dd($string);    
        $dataUser = json_decode($string, true);
//        dd($dataUser); 
        $data = array('name'=>strtoupper($dataUser['name']));
        Mail::send('mail', $data, function($message) use ($data, $dataUser) {  
            $message->to($dataUser['email'], 'DigiScripts')->subject
                ('Confirmation Mail');
                $message->from('digiscript.jamsaica@gmail.com','New Registration');
        });

        $data1 = array('name'=>'Admin');
        Mail::send('mailadmin', $data1, function($message) use ($data1, $dataUser) {  
            $message->to('911inform@yopmail.com', '911inform')->subject
                ('New Registration User');
                $message->from('digiscript.jamsaica@gmail.com','911 Inform');
        });        
        return "success";
    }
}