<?php


namespace BinomeWay\NovaPageManagerTool\Utils;


use BinomeWay\NovaPageManagerTool\Contracts\UrlBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PageUrlBuilder implements UrlBuilder
{
    protected Request $request;

    /**
     * UrlBuilder constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function make($model, array $arguments = []): string
    {
        return url($model->slug, $arguments);
    }
}
