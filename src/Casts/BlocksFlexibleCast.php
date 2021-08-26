<?php


namespace BinomeWay\NovaPageManagerTool\Casts;


use BinomeWay\NovaPageManagerTool\Facades\PageBuilder;
use Whitecube\NovaFlexibleContent\Value\FlexibleCast;

class BlocksFlexibleCast extends FlexibleCast
{

    protected function getLayoutMapping()
    {
        return PageBuilder::blocks()->toArray();
    }
}
