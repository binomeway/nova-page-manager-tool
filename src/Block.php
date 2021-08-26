<?php


namespace BinomeWay\NovaPageManagerTool;

use Whitecube\NovaFlexibleContent\Layouts\Layout;

abstract class Block extends Layout
{
    /**
     * The view path associated with this block.
     * @var string
     */
    protected string $component;

    function component(): string
    {
        return $this->component;
    }
}
