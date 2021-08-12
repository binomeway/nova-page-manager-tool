<?php


namespace BinomeWay\NovaPageManagerTool\Utils;


use BinomeWay\NovaPageManagerTool\Tags\PageStatusTag;
use BinomeWay\NovaTaxonomiesTool\Resources\Tag;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Manogi\Tiptap\Tiptap;
use Spatie\TagsField\Tags;

class FieldPresets
{
    private static $urlIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>';

    public static function slug($model, $from = 'title'): array
    {
        $link = $model->exists ? $model->url() : null;
        $viewLabel = __('View');

        $fields = [
            Slug::make(__('Slug'), 'slug')
                ->from($from)
                ->required()
                ->sortable()
                ->help($link ? "<a href=\"{$link}\" target='_blank'>$viewLabel</a>" : '')
                ->onlyOnForms(),
        ];

        if ($model->exists) {
            $fields[] = static::url($link, $model->slug)->exceptOnForms();
        }
        return $fields;
    }
    public static function status($tagType)
    {
        return Tags::make(__('Status'), 'status')
            ->type($tagType)
            ->single()
            ->withMeta(['placeholder' => __('Set status')])
            ->withLinkToTagResource(Tag::class)
            ;
    }
    public static function url($link, $text): Text
    {
        return Text::make('Slug', function () use ($link, $text) {
            $icon = static::$urlIcon;
            return "<a href='{$link }' class='inline-flex items-center' target='_blank'>
                    {$icon} {$text}
                </a>";
        })
            ->asHtml();
    }

    public static function content(): Tiptap
    {
        return Tiptap::make(__('Content'), 'content')
            ->required()
            ->headingLevels([2, 3, 4])
            ->buttons([
                'heading',
                'italic',
                'bold',
                'code',
                'link',
                'strike',
                'underline',
                'bullet_list',
                'ordered_list',
                'code_block',
                'blockquote',
                'table',
                'horizontal_rule',
                'edit_html',
            ]);
    }


    public static function imageCustomProperties(): array
    {
        return [
            Text::make(__('Title'), 'title')
                ->nullable(),

            Textarea::make(__('Description'), 'description')
                ->nullable()
                ->help(__('This should describe in few words what this photo represents. The description it will be used for the alt attribute of the image tag.')),
        ];
    }

    public static function thumbnail($help = null)
    {
        $help = $help ?? __('This image will be present on the card header on list pages.');

        return Images::make(__('Thumbnail'), 'thumbnail')
            ->showStatistics()
            ->enableExistingMedia()
            ->croppable()
            ->help($help)
            ->withResponsiveImages()
            ->customPropertiesFields(FieldPresets::imageCustomProperties());
    }

    public static function banner($help = null)
    {
        $help = $help ?? __('This image will be present on the single page as a cover.');
        return Images::make(__('Banner'), 'banner')
            ->enableExistingMedia()
            ->showStatistics()
            ->croppable()
            ->help($help)
            ->hideFromIndex()
            ->customPropertiesFields(FieldPresets::imageCustomProperties());
    }

    public static function facebookImage($help = null)
    {
        $help = $help ?? __('By default when sharing on Facebook the banner image will be used. Set a Facebook thumbnail only if you want to use a different image than the banner.');

        return Images::make(__('Facebook Thumbnail'), 'facebook')
            ->enableExistingMedia()
            ->showStatistics()
            ->croppable()
            ->help($help)
            ->customPropertiesFields(FieldPresets::imageCustomProperties());
    }

    public static function gallery($help = null)
    {
        return Images::make(__('Gallery'), 'default')
            ->enableExistingMedia()
            ->showStatistics()
            ->help($help)
            ->showStatistics()
            ->hideFromIndex()
            ->withResponsiveImages()
            ->customPropertiesFields(FieldPresets::imageCustomProperties());
    }


    public static function timestamps(): array
    {
        return [
            DateTime::make('Created At')->onlyOnDetail()->readonly(),
            DateTime::make('Updated At')->onlyOnDetail()->readonly(),
        ];
    }

    public static function excerpt()
    {
        return Textarea::make(__('Summary'), 'excerpt')
            ->rows(2)
            ->nullable();
    }

    public static function meta()
    {
        return Code::make(__('Meta'), 'meta')->json();
    }
}
