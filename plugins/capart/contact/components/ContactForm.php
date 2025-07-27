<?php namespace Capart\Contact\Components;

use Cms\Classes\ComponentBase;
use Input;
use Mail;
use Validator;
use Redirect;

class ContactForm extends ComponentBase
{
    public function ComponentDetails()
    {
        return [
            'name' => 'Contact Form',
            'description' => 'Simple contact form'
        ];
    }


    public function onSend() {

        $validator = Validator::make(

            [
                'name' => Input::get('name'),
                'email' => Input::get('email')
            ],

            [
                'name' => 'required',
                'email' => 'required|email'
            ]
        );
        
        if($validator->fails()){
            
            return Redirect::back()->withErrors($validator);
        
        } else { 

            $vars = ['name' => Input::get('name'), 'lname' => Input::get('lname'), 'email' => Input::get('email'), 'content' => Input::get('content')];

            Mail::send('capart.contact::mail.message', $vars, function($message) {
                $message->to('nikaberidze030506@gmail.com', 'Admin Person');
                $message->subject('New message from contact form');
            });
        }
    }
}
