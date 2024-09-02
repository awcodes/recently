<?php

namespace Awcodes\Recently\Database\Factories;

use Awcodes\Recently\Models\RecentEntry;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecentEntryFactory extends Factory
{
    protected $model = RecentEntry::class;

    public function definition(): array
    {
        return [
            'user_id' => 1,
            'url' => $this->faker->url(),
            'icon' => 'heroicon-o-rectangle-stack',
            'title' => $this->faker->words(mt_rand(3, 5), true),
        ];
    }
}
