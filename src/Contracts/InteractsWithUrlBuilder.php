<?php


namespace BinomeWay\NovaPageManagerTool\Contracts;


interface InteractsWithUrlBuilder
{
    function url(array $arguments = []): string;
}
