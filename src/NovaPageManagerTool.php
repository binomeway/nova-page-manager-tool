<?php

namespace BinomeWay\NovaPageManagerTool;

use BinomeWay\NovaPageManagerTool\Nova\Resources\Page;
use BinomeWay\NovaPageManagerTool\Tags\PagePositionsTag;
use BinomeWay\NovaPageManagerTool\Tags\PageStatusTag;
use BinomeWay\NovaTaxonomiesTool\Facades\Taxonomies;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class NovaPageManagerTool extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        //Nova::script('nova-page-manager-tool', __DIR__.'/../dist/js/tool.js');
        //Nova::style('nova-page-manager-tool', __DIR__.'/../dist/css/tool.css');

        $resources =  array_values(config('nova-page-manager-tool.resources'));
        Nova::resources($resources);

        Taxonomies::addTypes([
            PagePositionsTag::NAME => PagePositionsTag::DISPLAY,
            PageStatusTag::NAME => PageStatusTag::DISPLAY,
        ]);
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function renderNavigation()
    {
        return view('nova-page-manager-tool::navigation');
    }
}
