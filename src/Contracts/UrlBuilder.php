<?php


namespace BinomeWay\NovaPageManagerTool\Contracts;


interface UrlBuilder
{
    public function make($model, array $arguments = []): string;
}
