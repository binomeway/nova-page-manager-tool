<?php


namespace BinomeWay\NovaPageManagerTool\Layouts;


use Manogi\Tiptap\Tiptap;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class ContentSectionLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'content-section';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Content Section';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Tiptap::make(__('Content'), 'content')
                ->required()
                ->stacked()
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
                ]),
        ];
    }
}
