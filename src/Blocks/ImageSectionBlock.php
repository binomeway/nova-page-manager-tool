<?php


namespace BinomeWay\NovaPageManagerTool\Blocks;

use BinomeWay\NovaPageManagerTool\Block;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Spatie\MediaLibrary\HasMedia;
use Whitecube\NovaFlexibleContent\Concerns\HasMediaLibrary;

class ImageSectionBlock extends Block implements HasMedia
{
    use HasMediaLibrary;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'image-section';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Image Section';

    protected string $component = 'nova-page-manager-tool::blocks.image-section';


    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Images::make(__('Images'), 'images')
                ->customPropertiesFields([
                    Text::make(__('Alt Text'), 'alt')->nullable(),
                    Textarea::make(__('Description'), 'description')->nullable(),
                ])->nullable(),
        ];
    }
}
