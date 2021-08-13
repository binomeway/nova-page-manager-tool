# Nova Page Manager Tool

Manage static pages from your Nova panel.

## Prerequisites

This tool depends on the following packages:

- [binomeway/nova-taxonomies-tool](https://github.com/binomeway/nova-taxonomies-tool)

Please, refer to their documentation for more details.

## Installation

Register the tool in your `NovaServiceProvider.php`

```php
public function tools(){
    return [
        \BinomeWay\NovaPageManagerTool\NovaPageManagerTool::make(),
    ];
}
```

Publish the migrations.

```shell
php artisan vendor:publish --provider="\BinomeWay\NovaPageManagerTool\ToolServiceProvider" --tag="migrations"
```

Configure the tool.

```shell
php artisan vendor:publish --provider="\BinomeWay\NovaPageManagerTool\ToolServiceProvider" --tag="config"
```

**Optionally**, customise the tool's views.

```shell
php artisan vendor:publish --provider="\BinomeWay\NovaPageManagerTool\ToolServiceProvider" --tag="views"
```

## Usage

### Registering Templates

Adding types from your package.

```php
    use  \BinomeWay\NovaPageManagerTool\Facades\TemplateManager;
    use  \BinomeWay\NovaPageManagerTool\Template;
    
    public function boot() {
        TemplateManager::register([
        
            Template::make('label', 'namespace::path.to.view', 'group'),
            Template::make('About Us', 'pages.about-us', 'Global'),
            
        ]);
    }
```

