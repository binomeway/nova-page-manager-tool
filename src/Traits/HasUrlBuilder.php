<?php


namespace BinomeWay\NovaPageManagerTool\Traits;

use BinomeWay\NovaPageManagerTool\Utils\PageUrlBuilder;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait HasUrlBuilder
 * @package BinomeWay\NovaPageManagerTool\Traits
 * @mixin Model
 */
trait HasUrlBuilder
{
    public function url(array $arguments = []): string
    {
        $builderClass = config('nova-page-manager-tool.url_builder.page', PageUrlBuilder::class);

        return app($builderClass)->make($this, $arguments);
    }
}
