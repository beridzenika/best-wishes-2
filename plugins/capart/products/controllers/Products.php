<?php namespace Capart\Products\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Capart\Products\Models\Product;
use Illuminate\Support\Arr;
use Flash;
use Redirect;

class Products extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController', 'Backend\Behaviors\ReorderController'    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Capart.Products', 'products', 'products');
    }
    
    public function onSetPrice()
    {
        $params = \request()->all();
        if (!Arr::get($params, 'products')) {
            Flash::error("აირჩიეთ პროდუქტები");
            return;
        }
        if (!Arr::get($params, 'price')) {
            Flash::error("მიუთითეთ ფასი");
            return;
        }

        (new Product)->whereIn('id', Arr::get($params, 'products'))->update([
            'price' => Arr::get($params, 'price'),
            'price_before_sale' => Arr::get($params, 'price_before_sale') ?: 0
        ]);
        Flash::success("ფასი წარმატებით განახლდა");
        return Redirect::refresh();
    }
}
