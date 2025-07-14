@props(['tab', 'icon', 'label'])

<button @click="$store.tab = '{{ $tab }}'" :class="$store.tab === '{{ $tab }}' ? 'bg-white text-purple-600' : 'hover:bg-purple-600 hover:bg-opacity-50'"
        class="flex items-center space-x-3 w-full px-4 py-2 rounded-xl transition">
    <span>{{ $icon }}</span>
    <span>{{ $label }}</span>
</button>
