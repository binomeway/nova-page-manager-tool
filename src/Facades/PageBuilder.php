<?php


namespace BinomeWay\NovaPageManagerTool\Facades;


use Illuminate\Support\Facades\Facade;

class PageBuilder extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \BinomeWay\NovaPageManagerTool\Services\PageBuilder::class;
    }

}
