<?php

namespace Capart\Products\Components;

use Capart\Categories\Models\Category;
use Capart\Products\Models\Colors;
use Capart\Products\Models\Product;
use Cms\Classes\ComponentBase;
use Winter\Builder\Components\RecordList;

class FilterProducts extends RecordList
{
    public $Products;
    public $Categories;
    public $Colors;

    public function componentDetails()
    {
        return [
            'name'  => 'filter products',
            'description'  => 'filter products'
        ];
    }

    public function onRun()
    {
        $this->setProperties(array_merge($this->properties, ['recordsPerPage' => 9]));
        $this->Categories = Category::active()->get();
        $this->Colors = Colors::active()->get();
        $Products = Product::active();
        $this->FilterProducts($Products);
        $this->SortProducts($Products);
        $this->Products = $this->paginate($Products);
    }

    private function FilterProducts($Products)
    {
        if ($CatID = Input('cat_id')) {
            $Products->category($CatID);
        }
        if ($ColorID = Input('color_id')) {
            $Products->color($ColorID);
        }
        if ($Keyword = Input('keyword')) {
            $Products->keyword($Keyword);
        }
    }

    private function SortProducts($Products)
    {
        switch (Input('sort')) {
            case 1:
                $Products->orderBy('price', 'asc');
                break;
            case 2:
                $Products->orderBy('price', 'desc');
                break;
            default:
                $Products->orderBy('sort_order', 'asc');
        }
    }
}
