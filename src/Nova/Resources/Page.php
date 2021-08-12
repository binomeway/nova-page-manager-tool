<?php


namespace BinomeWay\NovaPageManagerTool\Nova\Resources;


use BinomeWay\NovaPageManagerTool\Models\Page as PageModel;
use BinomeWay\NovaPageManagerTool\Nova\Filters\SingleTag;
use BinomeWay\NovaPageManagerTool\Tags\PageStatusTag;
use BinomeWay\NovaPageManagerTool\Nova\Actions\{UpdatePosition, UpdateSingleTag, UpdateStatus, UpdateTag};
use BinomeWay\NovaPageManagerTool\Nova\Filters\StatusType;
use BinomeWay\NovaPageManagerTool\Services\TemplateManager;
use BinomeWay\NovaPageManagerTool\Tags\PagePositionsTag;
use BinomeWay\NovaPageManagerTool\Utils\FieldPresets;
use BinomeWay\NovaTaxonomiesTool\Resources\Tag;
use Eminiarts\Tabs\{Tab, Tabs, TabsOnEdit};
use Illuminate\Http\Request;
use Laravel\Nova\Fields\{Badge, ID, Select, Slug, Text};
use Laravel\Nova\Resource;
use Spatie\TagsField\Tags;

class Page extends Resource
{
    use TabsOnEdit;

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
        'id', 'title', 'content', 'slug', 'label',
    ];

    public function fields(Request $request)
    {
        return [
            Text::make(__('Title'), 'title')
                ->sortable()
                ->required(),

            Slug::make(__('Slug'), 'slug')
                ->from('title')
                ->sortable()
                ->required(),

            Text::make(__('Label'), 'label')
                ->help(__('This will be used when the page is placed in menu list, if left empty the title will be the default value.'))
                ->sortable()
                ->nullable(),

            FieldPresets::status(PageStatusTag::NAME)->sortable(),

            Select::make(__('Template'), 'template')
                ->options(function () {
                    return app(TemplateManager::class)->templates();
                })
                ->default('default')
                ->searchable()
                ->displayUsingLabels()
                ->hideFromIndex(),

            Tags::make(__('Positions'), 'positions')
                ->type(PagePositionsTag::NAME)
                ->nullable()
                ->withLinkToTagResource(Tag::class)
                ->withMeta(['placeholder' => __('Add position')])
                ->help(__('Add a position tag where this page should be visible.'))->hideFromIndex(),

            Tabs::make(__('Tabs'), [
                Tab::make(__('Body'), [
                    FieldPresets::content(),
                ]),

                /*Tab::make(__('Media'), [
                    // THUMBNAIL
                  //  FieldPresets::thumbnail(),

                    // BANNER
                   // FieldPresets::banner()->hideFromIndex(),
                ]),*/

                Tab::make(__('Other'), [
                    FieldPresets::meta(),
                ]),
            ]),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            SingleTag::make()
                ->withName(__('By Status'))
                ->withTagType(PageStatusTag::NAME)
        ];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Illuminate\Http\Request $request
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
