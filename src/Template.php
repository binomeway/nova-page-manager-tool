<?php


namespace BinomeWay\NovaPageManagerTool;


use Illuminate\Contracts\Support\Arrayable;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class Template implements Arrayable
{
    private string $path;
    private string $label;
    private string $group;

    /**
     * Template constructor.
     * @param string $label
     * @param string $path
     * @param string $group
     */
    public function __construct(string $label, string $path, string $group)
    {
        $this->path = $path;
        $this->label = $label;
        $this->group = $group;
    }

    #[Pure]
    public static function make(...$args): static
    {
        return new static(...$args);
    }

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
