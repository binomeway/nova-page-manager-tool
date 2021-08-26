<?php


namespace BinomeWay\NovaPageManagerTool\Services;


use Illuminate\Support\Collection;
use JetBrains\PhpStorm\Pure;

class PageBuilder
{
    private Collection $blocks;

    public function __construct()
    {
        $this->blocks = collect();

        $this->register(config('nova-page-manager-tool.blocks', []));
    }

    public function register(array $blocks): static
    {
        foreach ($blocks as $name => $block) {
            $this->blocks->put($name, $block);
        }

        return $this;
    }

    public function blocks(): Collection
    {
        return $this->blocks;
    }

    #[Pure] public function hasAnyBlocks(): bool
    {
        return $this->blocks->count() > 0;
    }
}
