<?php namespace Capart\Contact;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'Capart\Contact\Components\ContactForm' =>'contactform'
        ];
    }

    public function registerSettings()
    {
    }
}
