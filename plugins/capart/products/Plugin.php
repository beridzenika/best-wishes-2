<?php namespace Capart\Products;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'Capart\Products\Components\FilterProducts' => 'filterproducts'
        ];
    }

    public function registerSettings()
    {
    }
}
