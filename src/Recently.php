<?php

declare(strict_types=1);

namespace Awcodes\Recently;

use BackedEnum;
use Filament\Facades\Filament;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Model;

class Recently
{
    public function add(string $url, string | BackedEnum | null $icon, string $title, ?Model $record = null): void
    {
        if ($icon instanceof Heroicon) {
            $icon = "heroicon-$icon->value";
        }

        /** @var class-string<Model> $model */
        $model = config('recently.model');

        $userId = Filament::auth()->user()->getAuthIdentifier();

        $attributes = [
            'user_id' => $userId,
            'url' => $url,
            'icon' => $icon ?? '',
            'title' => $title,
        ];

        if ($this->tracksRecords()) {
            $attributes['recordable_type'] = $record?->getMorphClass();
            $attributes['recordable_id'] = $record?->getKey();
        }

        $model::updateOrCreate([
            'user_id' => $userId,
            'url' => $url,
        ], $attributes);

        $this->prune($model, $userId);
    }

    public function tracksRecords(): bool
    {
        return (bool) config('recently.track_records', false);
    }

    /**
     * @param  class-string<Model>  $model
     */
    protected function prune(string $model, int | string $userId): void
    {
        $limit = config('recently.max_stored_items');

        if (blank($limit)) {
            return;
        }

        $keepIds = $model::query()
            ->where('user_id', $userId)
            ->when($this->tracksRecords(), fn ($query) => $query->whereRecordExists())
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->limit((int) $limit)
            ->pluck('id');

        $model::query()
            ->where('user_id', $userId)
            ->whereNotIn('id', $keepIds)
            ->delete();
    }
}
