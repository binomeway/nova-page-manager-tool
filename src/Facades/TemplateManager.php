<?php


namespace BinomeWay\NovaPageManagerTool\Facades;


use Illuminate\Support\Facades\Facade;

class TemplateManager extends Facade
{
    protected static function getFacadeAccessor()
    {
       return \BinomeWay\NovaPageManagerTool\Services\TemplateManager::class;
    }
}
