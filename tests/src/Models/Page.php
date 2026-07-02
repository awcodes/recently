<?php

declare(strict_types=1);

namespace Awcodes\Recently\Tests\Models;

use Awcodes\Recently\Tests\Database\Factories\PageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected static function newFactory(): PageFactory
    {
        return new PageFactory;
    }
}
