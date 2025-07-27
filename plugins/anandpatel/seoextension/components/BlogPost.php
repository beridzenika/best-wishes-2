<?php namespace AnandPatel\SeoExtension\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use Cms\Classes\Theme;
use Event;

class BlogPost extends ComponentBase
{

    public $page;
    public $seo_title;
    public $title;
    public $seo_description;
    public $seo_keywords;
    public $canonical_url;
    public $redirect_url;
    public $robot_index;
    public $robot_follow;

    public function componentDetails()
    {
        return [
            'name'        => 'anandpatel.seoextension::lang.component.blog.name',
            'description' => 'anandpatel.seoextension::lang.component.blog.description'
        ];
    }

    public function defineProperties()
    {
        return [
            "post" => [
                "title" => "data",
                "default" => "post"
            ]
        ];
    }

    public function onRun()
    {
        $record = $this->page->components['builderDetails']->record;
        $this->page["hasBlog"] = 1;
        $this->seo_title = $record->title;
        $this->title = $record->title;
        $this->seo_description = $this->page->meta_description;
    }

}
