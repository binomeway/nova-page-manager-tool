<?php


namespace BinomeWay\NovaPageManagerTool\Nova\Resources;


use BinomeWay\NovaPageManagerTool\Facades\PageBuilder;
use BinomeWay\NovaPageManagerTool\Facades\TemplateManager;
use BinomeWay\NovaPageManagerTool\Presets\PageBuilderPreset;
use BinomeWay\NovaPageManagerTool\Tags\PagePositionsTag;
use BinomeWay\NovaPageManagerTool\Tags\PageStatusTag;
use BinomeWay\NovaPageManagerTool\Utils\FieldPresets;
use BinomeWay\NovaTaxonomiesTool\Nova\Actions\{UpdateSingleTag, UpdateTag};
use BinomeWay\NovaTaxonomiesTool\Nova\Filters\MultiTags;
use BinomeWay\NovaTaxonomiesTool\Nova\Filters\SingleTag;
use BinomeWay\NovaTaxonomiesTool\Resources\Tag;
use Eminiarts\Tabs\{Tab, Tabs, TabsOnEdit};
use Illuminate\Http\Request;
use Laravel\Nova\Fields\{Line, Select, Slug, Stack, Text};
use Laravel\Nova\Resource;
use OptimistDigital\NovaSortable\Traits\HasSortableRows;
use Spatie\TagsField\Tags;
use Whitecube\NovaFlexibleContent\Flexible;

class Page extends Resource
{
    use TabsOnEdit, HasSortableRows;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \BinomeWay\NovaPageManagerTool\Models\Page::class;

    public static $displayInNavigation = false;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'title', 'summary', 'slug', 'label',
    ];

    public static $with = ['tags'];

    public function fields(Request $request)
    {
        return [

            Stack::make(__('Title'), [
                Line::make(__('Title'),'title')->asHeading(),

                Line::make(__('Slug'), fn() => view('nova-page-manager-tool::nova.slug-link', [
                    'slug' => $this->slug,
                    'url' => $this->url(),
                ])->render()
                )->asHtml()->asSmall(),

            ])->sortable(),


            Text::make(__('Title'), 'title')
                ->onlyOnForms()
                ->required(),

            Slug::make(__('Slug'), 'slug')
                ->from('title')
                ->sortable()
                ->onlyOnForms()
                ->required(),

            Text::make(__('Label'), 'label')
                ->help(__('This will be used when the page is placed in menu list, if left empty the title will be the default value.'))
                ->hideFromIndex()
                ->nullable(),

            Select::make(__('Template'), 'template')
                ->options(fn() => TemplateManager::toSelectOptions())
                ->searchable(fn() => TemplateManager::isSearchable())
                ->displayUsingLabels()
                ->nullable()
                ->hideFromIndex(),

            FieldPresets::status(PageStatusTag::NAME)->sortable(),

            Tags::make(__('Positions'), 'positions')
                ->type(PagePositionsTag::NAME)
                ->nullable()
                ->withLinkToTagResource(Tag::class)
                ->withMeta(['placeholder' => __('Add position'), 'help' => 'Test'])
                ->help(__('Add a position tag where this page should be visible.'))
                ->hideFromIndex(),

            FieldPresets::tiptap(__('Summary'), 'summary'),

            Tabs::make(__('Content'), [
                Tab::make(__('Page Builder'), $this->otherFields())
            ]),
        ];
    }

    private function otherFields(): array
    {
        $fields = [];
        if (PageBuilder::hasAnyBlocks()) {
            $fields[] = Flexible::make(__('Blocks'), 'blocks')
                ->preset(config('nova-page-manager-tool.preset', PageBuilderPreset::class));
        }

        return $fields;
    }

    /**
     * Get the filters available for the resource.
     *
     * @param Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            SingleTag::make()
                ->withName(__('By Status'))
                ->withTagType(PageStatusTag::NAME),

            MultiTags::make()
                ->withName(__('By Position'))
                ->withTagType(PagePositionsTag::NAME),
        ];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            UpdateTag::make(PagePositionsTag::NAME, PagePositionsTag::DISPLAY),
            UpdateSingleTag::make(PageStatusTag::NAME, PageStatusTag::DISPLAY),
        ];
    }
}
