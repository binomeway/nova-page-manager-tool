<?php

return [

    /**
     * The table name for pages collection
     */
    'pages_table_name' => 'pages',


    /**
     * Customise the Nova resources that should be used
     */
    'resources' => [
        'pages' => \BinomeWay\NovaPageManagerTool\Nova\Resources\Page::class,
    ],


    /**
     * If there are more templates than the set threshold,
     * then it will switch to a searchable field instead of the normal one
     *
     * Default threshold is 10.
     */
    'templates_searchable_threshold' => 10,

    /**
     * The default templates used for selection on the Page resource.
     */
    'templates' => [
        \BinomeWay\NovaPageManagerTool\Templates\DefaultTemplate::class,
    ],


    /**
     * If there are more layouts than the set threshold,
     * then it will switch to a searchable field instead of the normal one
     *
     * Default threshold is 10.
     */
    'layouts_searchable_threshold' => 10,


    /**
     * The default preset used for the page builder
     */
    'preset' => \BinomeWay\NovaPageManagerTool\Presets\PageBuilderPreset::class,


    /**
     * The default layouts that are available for the page builder
     *
     * If there are no layouts, the flexible filed will be hidden.
     */
    'layouts' => [
        \BinomeWay\NovaPageManagerTool\Layouts\ContentSectionLayout::class,
    ],

];
