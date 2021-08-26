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

or use the generator command:

```shell
php artisan nova-page-manager:template AboutTemplate
```

It will generate for you the template class, and the view file.

#### Registering Templates

After you have defined your template, register it from a ServiceProvider. It can be placed in the `AppServiceProvider`
, `ViewServiceProvider` or any other service provider.

```php
use  \BinomeWay\NovaPageManagerTool\Facades\TemplateManager;

public function boot() {
    TemplateManager::register([
   
       \App\Templates\AboutTemplate::class,
   
    ]);
}
```

### Page Builder

#### Blocks

##### Define Blocks

```php
namespace App\Blocks;

use BinomeWay\NovaPageManagerTool\Block;
use Laravel\Nova\Fields\Textarea;

class DescriptionSectionBlock extends Block
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'description-section';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Description Section';

    /**
     * The view path associated with this block.
     * @var string
     */
    protected string $component = 'blocks.description-section';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Textarea::make(__('Description'), 'description')
        ];
    }
    
    public function customLogic(){
        // You can define custom methods and use them within view.
    }
}
```

##### Register Blocks

In your `AppServiceProvider` within the `boot` method, you can use the PageBuilder facade to register blocks.

```php

// AppServiceProvider.php
use BinomeWay\NovaPageManagerTool\Facades\PageBuilder;

function boot() {
    
    PageBuilder::register([
        'description-section' => \App\Blocks\DescriptionSectionBlock::class,
    ]);
}
```

##### Rendering Blocks

In your template you can iterate over each block and just include the associated component of the block.

```html
<x-app-layout>
    <x-slot name="header">
        {{ $page->title }}
    </x-slot>

    <div class="py-12 max-w-2xl mx-auto">
        <article class="prose prose-lg">
            @foreach($page->blocks as $block)
                @include($block->component())
            @endforeach
        </article>
    </div>
</x-app-layout>
```

#### Presets

##### Define Presets

TODO: documentation

##### Register Presets

TODO: documentation

## Roadmap

- [X] ~~Page builder~~
- [ ] Improved publishing workflow
- [ ] Scheduled publishing
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
- Added helper methods for *status* tag within `Page` model.
- Tweaked page builder

### 1.0.2

- Implemented position tag filtering

### 1.0.1

- Changed text for 'Other' into Page Builder
- Changed text for 'Meta' into Blocks

### 1.0.0

- Release
