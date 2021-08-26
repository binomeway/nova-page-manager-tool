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
     * The default namespace where classes should be generated to and autoloaded from.
     * Will be prefixed with the root namespace
     */
    'templates_namespace' => 'Templates',


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

    /**
     * The url builder is used whenever the 'url' within the model is called.
     * You can create your own url builder by either extending the PageUrlBuilder or
     * by implementing the BinomeWay\NovaPageManagerTool\Contracts\UrlBuilder contract.
     */
    'url_builder' => [
        'page' => \BinomeWay\NovaPageManagerTool\Utils\PageUrlBuilder::class,
    ],
];
