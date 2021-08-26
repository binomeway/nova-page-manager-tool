<?php


namespace BinomeWay\NovaPageManagerTool\Services;


use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;

class TemplateManager
{
    private Collection $templates;
    private Collection $resolved;
    private Filesystem $files;

    /**
     * PageManager constructor.
     */
    public function __construct(Filesystem $files)
    {
        $this->files = $files;
        $this->templates = collect();
        $this->resolved = collect();
    }

    public function register(array $templates): static
    {
        $templates = array_filter($templates, fn($template) => class_exists($template));

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

    public function autoloadTemplates()
    {
        $templates =  config('nova-page-manager-tool.templates', []);
        $templatesPath = config('nova-page-manager-tool.templates_namespace', 'Templates');


        // Collect all the templates from the App folder
        $files = $this->files->allFiles(app_path($templatesPath));

        $namespace = app()->getNamespace() . "{$templatesPath}\\";

        foreach ($files as $file) {
            $name = $file->getFilenameWithoutExtension();
            $templates[] = $namespace . $name;
        }

        $this->register($templates);
    }
}
