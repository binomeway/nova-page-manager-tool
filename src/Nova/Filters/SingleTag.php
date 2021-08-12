<?php


namespace BinomeWay\NovaPageManagerTool\Nova\Filters;


use BinomeWay\NovaPageManagerTool\Tags\PageStatusTag;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;
use Spatie\Tags\Tag;

class SingleTag extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    private string $tagType;

    public function withTagType(string $type): static
    {
        $this->tagType = $type;

        return $this;
    }

    public function withName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function apply(Request $request, $query, $value)
    {
        return $query->withAnyTags([$value], $this->tagType);
    }

    public function options(Request $request)
    {
        return Tag::getWithType($this->tagType)
            ->pluck('name', 'name')
            ->toArray();
    }
}
