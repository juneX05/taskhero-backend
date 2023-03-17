<?php

namespace Application\Modules\Core\Notifiers;

use Illuminate\Support\Facades\Mail;

class Notifiers
{
    public static function sendEmail($subject, $body, $recipient_name, $recipient_email) {
       try {
           Mail::raw($body
               , function ($message) use ($recipient_name, $recipient_email, $subject) {
                   $message->to($recipient_email, $recipient_name)->subject($subject);
                   $message->from('joelvankibona@gmail.com', 'Joel Kibona');
               });
           return true;
       } catch (\Exception $e) {
           return false;
       }
    }
}
