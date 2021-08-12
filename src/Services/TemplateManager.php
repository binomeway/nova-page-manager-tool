<?php


namespace BinomeWay\NovaPageManagerTool\Services;


use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class TemplateManager
{
    private $templates = [];
    private $defaultPath;

    /**
     * PageManager constructor.
     */
    public function __construct($templatesPath = 'pages/templates')
    {
        $this->defaultPath = $templatesPath;
    }


    public function templates($folder = null): \Illuminate\Support\Collection
    {
        if(!$this->templates){
            $this->templates = $this->findTemplates($folder);
        }

        return $this->templates;
    }

    public function findTemplates($folder = null): \Illuminate\Support\Collection
    {
        // TODO: Find a way to make this work as a package.
        return collect();

        return $this->collectFiles($this->makePath($folder))->mapWithKeys(function($file){
            return $this->parseFileName($file->getFilenameWithoutExtension());
        });
    }

    private function makePath($folder = null)
    {
        $path = $folder ?? $this->defaultPath;

        return resource_path("views/{$path}");
    }

    private function parseFileName($filenameWithoutExtension)
    {
        $value = str_replace('.blade', '', $filenameWithoutExtension);
        $display = Str::title(str_replace(['-', '_'], ' ', $value));

        return [$value => $display];
    }

    private function collectFiles($path)
    {
        return collect(app(Filesystem::class)->files($path));
    }
}
