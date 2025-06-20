<?php

declare(strict_types=1);

namespace Awcodes\Recently\Tests\Database\Factories;

use Awcodes\Recently\Tests\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition(): array
    {
        $title = $this->faker->sentence();

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->sentences(mt_rand(3, 5), true),
        ];
    }
}
