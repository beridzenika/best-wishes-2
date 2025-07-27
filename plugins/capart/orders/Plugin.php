<?php namespace Capart\Orders;

use October\Rain\Support\Arr;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }

    public function registerListColumnTypes()
    {
        return [
            'special_order_statuses' => function($value) {
                $map = [
                    0 => '<div style="color:red">გადაუხდელი</div>',
                    1 => '<div style="color:green">გადახდილია</div>',
                    2 => '<div style="color:orange">გზაშია</div>',
                    3 => '<div style="color:black">ჩაბარებულია</div>',
                ];
                return Arr::get($map, $value);
            },
            'special_payment_type'  => function($value) {
                $map = [
                    0 => 'ნაღდი ანგარიშსწორებით',
                    1 => 'ბარათით'
                ];
                return Arr::get($map, $value);
            }
        ];
    }
}
