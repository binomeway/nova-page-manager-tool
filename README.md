# Nova Page Manager Tool

Manage static pages from your Nova panel.

## Prerequisites

This tool depends on the following packages:

- [binomeway/nova-taxonomies-tool](https://github.com/binomeway/nova-taxonomies-tool)

Please, refer to its documentation for installation and usage instructions.

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

### Templates

#### Defining Templates

You can define a new template by creating a class and extend it from `BinomeWay\NovaPageManagerTool\Template`.

```php
namespace App\Templates;

use BinomeWay\NovaPageManagerTool\Template;

class AboutTemplate extends Template
{
    protected string $group = 'General'; // Displayed in the select field
    protected string $label = 'About Us'; // Displayed in the select field
    protected string $path = 'pages.about-us';
}

```

#### Registering Templates

After you have defined your template, register it from a ServiceProvider. It can be placed in the `AppServiceProvider`, `ViewServiceProvider` or any other service provider.

```php
use  \BinomeWay\NovaPageManagerTool\Facades\TemplateManager;

public function boot() {
    TemplateManager::register([
   
       \App\Templates\AboutTemplate::class,
   
    ]);
}
```
### Page Builder

#### Layouts

##### Define Layouts

TODO: documentation

##### Register Layouts

TODO: documentation

#### Presets

##### Define Presets

TODO: documentation

##### Register Presets

TODO: documentation


## Roadmap

- [X] ~~Page builder~~
- [ ] Improved publishing workflow
- [ ] Improved template system
- [ ] Versioning system
- [ ] Multi-Language support
- [ ] Collaborative editing
- [ ] Making the tool more extendable

## Credits

- [Codrin Axinte](https://github.com/codrin-axinte)


## Changelog

### 1.1.0
 - Added **sorting** for `Page` resource
 - Added URL builder for `Page`.
 - **Breaking Changes** Refactored `content` column into `summary` column.
 - Refactored `meta` column into `blocks` column
 - Removed `PageFactory` since it wasn't used. It will be added back, later.


### 1.0.2
 - Implemented position tag filtering

### 1.0.1
- Changed text for 'Other' into Page Builder
- Changed text for 'Meta' into Blocks

### 1.0.0
- Release
