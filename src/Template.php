<?php


namespace BinomeWay\NovaPageManagerTool;


use Illuminate\Contracts\Support\Arrayable;
use JetBrains\PhpStorm\ArrayShape;

abstract class Template implements Arrayable
{
    protected string $path;
    protected string $label;
    protected string $group;


    public function label(): string
    {
        return $this->label;
    }

    public function group(): string
    {
        return $this->group;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function view(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view($this->path);
    }

    public function __toString(): string
    {
        return "$this->label ($this->group)";
    }


    #[ArrayShape(['label' => "string", 'path' => "string", 'group' => "string"])]
    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'path' => $this->path,
            'group' => $this->group,
        ];
    }
}
