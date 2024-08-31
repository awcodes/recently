<?php

namespace Awcodes\Recently\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void add(string $url, string $icon, string $title)
 *
 * @see \Awcodes\Recently\Recently
 */
class Recently extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Awcodes\Recently\Recently::class;
    }
}
