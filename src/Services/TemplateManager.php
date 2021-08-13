<?php


namespace BinomeWay\NovaPageManagerTool\Services;


use BinomeWay\NovaPageManagerTool\Template;
use Illuminate\Support\Collection;

class TemplateManager
{
    private Collection $templates;

    /**
     * PageManager constructor.
     */
    public function __construct(array $templates = [])
    {
        $this->templates = collect();

        if ($templates) {
            $this->register($templates);
        }
    }

    public function register(array $templates): static
    {
        foreach ($templates as $template) {
            if ($template instanceof Template) {
                $this->templates->push($template);
            }
        }

        return $this;
    }

    public function templates($folder = null): \Illuminate\Support\Collection
    {
        return $this->templates;
    }

    public function toSelectOptions(): Collection
    {
        return $this->isSearchable()
            ? $this->mapForSearchable()
            : $this->mapDefaultOptions();
    }

    public function isSearchable(): bool
    {
        return $this->templates->count() > config('nova-page-manager-tool.templates_searchable_threshold', 10);
    }

    private function mapForSearchable(): Collection
    {
        return $this->templates->mapWithKeys(fn($template) => [$template->path() => $template]);
    }

    private function mapDefaultOptions(): Collection
    {
        return $this->templates->mapWithKeys(
            fn($template) => [$template->path() => $template->toArray()]
        );
    }
}
