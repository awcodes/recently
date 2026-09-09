<?php

declare(strict_types=1);

namespace Awcodes\Recently;

use BackedEnum;
use Filament\Facades\Filament;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Model;

class Recently
{
    public function add(string $url, string | BackedEnum | null $icon, string $title): void
    {
        if ($icon instanceof Heroicon) {
            $icon = "heroicon-$icon->value";
        }

        /** @var class-string<Model> $model */
        $model = config('recently.model');

        $userId = Filament::auth()->user()->getAuthIdentifier();

        $model::updateOrCreate([
            'user_id' => $userId,
            'url' => $url,
        ], [
            'user_id' => $userId,
            'url' => $url,
            'icon' => $icon ?? '',
            'title' => $title,
        ]);

        $this->prune($model, $userId);
    }

    /**
     * Keep only the most-recent `recently.max_items` entries for the user.
     * The table is otherwise unbounded — `max_items` caps the display, not storage.
     *
     * @param  class-string<Model>  $model
     */
    protected function prune(string $model, int|string $userId): void
    {
        $keepIds = $model::query()
            ->where('user_id', $userId)
            ->orderByDesc('updated_at')
            ->orderByDesc('id') // deterministic tiebreak when timestamps collide
            ->limit(config('recently.max_items'))
            ->pluck('id');

        $model::query()
            ->where('user_id', $userId)
            ->whereNotIn('id', $keepIds)
            ->delete();
    }
}
