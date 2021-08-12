<?php


namespace BinomeWay\NovaPageManagerTool\Services;


use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TemplateManager
{
    private Collection $paths;
    private $templates = [];

    /**
     * PageManager constructor.
     */
    public function __construct()
    {
        $this->paths = collect();
    }

    public function registerPath($group, array $paths): static
    {
        $this->paths->put($group, $paths);

        return $this;
    }


    public function templates($folder = null): \Illuminate\Support\Collection
    {
        if (!$this->templates) {
            $this->templates = $this->findTemplates();
        }

        return $this->templates;
    }

    public function findTemplates(): \Illuminate\Support\Collection
    {
        $templates = collect();

        foreach ($this->paths as $group => $paths) {

            $templates->put($group, $this->getTemplatesFromPath($paths));
        }

        debugbar()->debug($templates->toArray());

        return $templates;
    }

    public function getTemplatesFromPath($paths): Collection
    {
        return collect($paths)->mapWithKeys(fn($viewPath) => [$viewPath => view($viewPath)->getPath()]);
    }

    private function collectFiles($path): Collection
    {
        return collect(app(Filesystem::class)->files($path));
    }

    private function parseFileName($filenameWithoutExtension): array
    {
        $value = str_replace('.blade', '', $filenameWithoutExtension);
        $display = Str::title(str_replace(['-', '_'], ' ', $value));

        return [$value => $display];
    }
}
