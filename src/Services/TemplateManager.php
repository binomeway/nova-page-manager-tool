<?php


namespace BinomeWay\NovaPageManagerTool\Services;


use Illuminate\Support\Collection;

class TemplateManager
{
    private Collection $templates;
    private Collection $resolved;

    /**
     * PageManager constructor.
     */
    public function __construct(array $templates = [])
    {
        $this->templates = collect();
        $this->resolved = collect();

        if ($templates) {
            $this->register($templates);
        }
    }

    public function register(array $templates): static
    {
        foreach ($templates as $template) {
            $this->templates->push($template);
        }

        return $this;
    }

    public function toSelectOptions(): Collection
    {
        return $this->isSearchable()
            ? $this->mapForSearchable()
            : $this->mapDefaultOptions();
    }

    public function isSearchable(): bool
    {
        return $this->templates()->count() > config('nova-page-manager-tool.templates_searchable_threshold', 10);
    }

    public function templates(): \Illuminate\Support\Collection
    {
        if ($this->resolved->isEmpty()) {
            $this->resolve();
        }

        return $this->resolved;
    }

    private function resolve(): void
    {
        $this->templates->each(
            fn($template) => $this->resolved->push(app($template))
        );
    }

    private function mapForSearchable(): Collection
    {
        return $this->templates()->mapWithKeys(fn($template) => [$template->path() => $template]);
    }

    private function mapDefaultOptions(): Collection
    {
        return $this->templates()->mapWithKeys(
            fn($template) => [$template->path() => $template->toArray()]
        );
    }
}
