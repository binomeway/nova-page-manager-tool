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
];
