<?php

declare(strict_types=1);

namespace Awcodes\Recently\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void add(string $url, string|\BackedEnum|null $icon, string $title, ?\Illuminate\Database\Eloquent\Model $record = null)
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
