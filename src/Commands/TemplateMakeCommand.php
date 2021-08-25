<?php


namespace BinomeWay\NovaPageManagerTool\Commands;


use Illuminate\Console\GeneratorCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class TemplateMakeCommand extends GeneratorCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'nova-page-manager:template';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new template class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Template';

    private $viewPath;
    private $group;
    private $label;


    protected function getStub()
    {
        return $this->basePath('resources/stubs/Template.php.stub');
    }

    private function basePath(string $path)
    {
        return __DIR__ . "/../../{$path}";
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Templates';
    }

    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if it already exists'],
            ['label', null, InputOption::VALUE_REQUIRED, 'A representative name shown in the nova select input.'],
            ['view', null, InputOption::VALUE_REQUIRED, 'Path to the view for used by this template. Path must be in dot notation.'], // should generate a view as well.
            ['group', null, InputOption::VALUE_REQUIRED, 'The group the template is part of. Defaults to the application name.', config('app.name')],
        ];
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param string $stub
     * @param string $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $viewPath = $this->getViewPath();

        $this->makeView($viewPath);

        // Set Defaults
        $replaceMap = [
            'DummyPath' => $viewPath,
            'DummyLabel' => $this->option('label') ?? $this->getLabel(),
            'DummyGroup' => $this->option('group'),
        ];


        $stub = parent::replaceClass($stub, $name);

        return str_replace(
            array_keys($replaceMap),
            array_values($replaceMap),
            $stub
        );
    }

    private function getCleanName(): string
    {
        return str_replace('Template', '', $this->argument('name'));
    }

    private function getLabel(): string
    {
        return ucwords(Str::snake($this->getCleanName(), ' '));
    }

    private function getViewPath(): string
    {
        if ($view = $this->option('view')) {
            return $view;
        }

        $viewName = Str::kebab($this->getCleanName());

        return "pages.{$viewName}";
    }

    private function makeView($viewPath)
    {
        $filePath = $this->viewPath(str_replace('.', '/', $viewPath)) . '.blade.php';

        if(!$this->option('force') && $this->files->exists($filePath)){
            $this->info('View already exists.');
            return $this;
        }

        $this->makeDirectory($filePath);

        $stub = $this->files->get($this->basePath('resources/stubs/template.blade.php.stub'));

        $content = str_replace('DummyComment', Inspiring::quote(), $stub);

        $this->files->put($filePath, $content);
        $this->info('View created successfully.');

        return $this;
    }
}
