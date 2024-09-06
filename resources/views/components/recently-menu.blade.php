@php
    $hasTooltip = filled($tooltip);
@endphp
<div class="recently-menu">
    <x-filament::dropdown placement="bottom-end" :teleport="true" :width="$width">
        <x-slot name="trigger">
            <button
                @if ($hasTooltip)
                    x-tooltip="{
                        content: @js($tooltip),
                        theme: $store.theme,
                    }"
                @endif

                @class([
                    'flex flex-shrink-0 bg-gray-100 items-center justify-center text-primary-500 hover:text-primary-900 dark:bg-gray-800 hover:bg-primary-500 dark:hover:bg-primary-500',
                    'rounded-full' => $rounded,
                    'rounded-md' => ! $rounded,
                    'w-8 h-8' => ! $label,
                    'py-1 ps-3 pe-4 gap-1 w-full' => $label,
                ])
                aria-label="{{ __('recently::recently.trigger_label') }}"
            >
                <x-filament::icon
                    alias="recently::trigger-icon"
                    :icon="$icon"
                    class="w-5 h-5"
                />
                @if ($label)
                    <span>{{ $label }}</span>
                @endif
            </button>
        </x-slot>
        @if (filled($records))
            <x-filament::dropdown.list>
            @foreach($records as $record)
                <x-filament::dropdown.list.item
                    :icon="$record['icon']"
                    :href="$record['url']"
                    tag="a"
                >
                    {{ $record['title'] }}
                </x-filament::dropdown.list.item>
            @endforeach
            </x-filament::dropdown.list>
            <x-filament::dropdown.list>
                <x-filament::dropdown.list.item
                    wire:click="clearRecords()"
                    color="danger"
                    icon="heroicon-o-trash"
                >
                    {{ __('recently::recently.clear_records') }}
                </x-filament::dropdown.list.item>
            </x-filament::dropdown.list>
        @else
            <x-filament::dropdown.list>
                <x-filament::dropdown.list.item
                    :disabled="true"
                >
                    {{ __('recently::recently.no_records') }}
                </x-filament::dropdown.list.item>
            </x-filament::dropdown.list>
        @endif
    </x-filament::dropdown>
</div>
