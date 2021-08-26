<?php


namespace BinomeWay\NovaPageManagerTool\Blocks;


use BinomeWay\NovaPageManagerTool\Block;
use Manogi\Tiptap\Tiptap;

class ContentSectionBlock extends Block
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

    protected string $component = 'nova-page-manager-tool::blocks.content-section';

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
