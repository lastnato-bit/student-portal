<div class="p-4">
    <h2 class="text-xl font-semibold mb-4 text-gray-800">🎉 Holidays</h2>

    <div class="overflow-x-auto rounded-lg shadow-md">
        <table class="w-full table-auto border-collapse bg-white text-sm">
            <thead class="bg-indigo-600 text-white">
                <tr>
                    <th class="text-left px-4 py-3">Date</th>
                    <th class="text-left px-4 py-3">Holiday</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($holidays as $holiday)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-2 text-gray-700">
                            {{ \Carbon\Carbon::parse($holiday['date'])->format('M d, Y') }}
                        </td>
                        <td class="px-4 py-2 font-medium text-gray-800">
                            {{ $holiday['title'] }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-4 py-4 text-center text-gray-500">
                            No holidays found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
