@props(['title', 'amount', 'icon', 'highlight' => false])

<div class="bg-white p-5 rounded-xl shadow {{ $highlight ? 'border-2 border-purple-500' : '' }}">
    <div class="flex items-center space-x-3">
        <div class="text-3xl">{{ $icon }}</div>
        <div>
            <div class="text-sm text-gray-500">{{ $title }}</div>
            <div class="text-lg font-bold text-gray-800">{{ $amount }}</div>
        </div>
    </div>
</div>
