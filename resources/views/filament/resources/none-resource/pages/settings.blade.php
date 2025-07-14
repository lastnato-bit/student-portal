<x-filament-panels::page>
    <x-filament::page>
    {{ $this->form }}
    <x-filament::button wire:click="save">
        Save Settings
    </x-filament::button>
</x-filament::page>

    <x-filament-panels::section>
        <x-filament-panels::header>
            <h2 class="text-xl font-semibold">Settings</h2>
        </x-filament-panels::header>

        <x-filament-panels::content>
            <p>Manage your application settings here.</p>
        </x-filament-panels::content>
    </x-filament-panels::section>
</x-filament-panels::page>

