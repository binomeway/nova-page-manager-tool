<?php


namespace BinomeWay\NovaPageManagerTool\Services;


use Illuminate\Support\Collection;
use JetBrains\PhpStorm\Pure;
use Whitecube\NovaFlexibleContent\Flexible;

class PageBuilder
{
    private Collection $blocks;

    public function __construct(array $blocks = [])
    {
        $this->blocks = collect();

        $this->register($blocks);
    }

    public function register(array $blocks): static
    {
        foreach ($blocks as $block) {
            $this->blocks->push($block);
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
