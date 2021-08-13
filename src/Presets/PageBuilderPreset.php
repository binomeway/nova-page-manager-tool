<?php


namespace BinomeWay\NovaPageManagerTool\Presets;




use BinomeWay\NovaPageManagerTool\Services\PageBuilder;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\Pure;
use Whitecube\NovaFlexibleContent\Flexible;
use Whitecube\NovaFlexibleContent\Layouts\Preset;

class PageBuilderPreset extends Preset
{

    /**
     * The registered blocks
     */
    protected Collection $blocks;
    protected int $searchableThreshold;

    /**
     * Create a new preset instance
     */
    public function __construct(PageBuilder $builder)
    {
        $this->blocks = $builder->blocks();
        $this->searchableThreshold = config('nova-page-manager-tool.layouts_searchable_threshold', 10);
    }

    public function handle(Flexible $field)
    {
        $field->button(__('Add new block'));
        $field->confirmRemove();
        $field->fullWidth();

        $this->blocks->each(fn($block) => $field->addLayout($block));

        if($this->blocks->count() > $this->searchableThreshold) {

            $field->menu(
                'flexible-search-menu',
                [
                    'selectLabel' => 'Press enter to select',
                    // the property on the layout entry
                    'label' => 'title',
                    // 'top', 'bottom', 'auto'
                    'openDirection' => 'auto',
                ]
            );
        }
    }
}
