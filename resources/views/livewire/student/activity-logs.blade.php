<div class="bg-white shadow rounded p-6">
    <h2 class="text-xl font-bold mb-4">🧾 My Activity Logs</h2>

    @if($logs->isEmpty())
        <p class="text-gray-500">No recent activity found.</p>
    @else
        <table class="w-full text-sm table-auto border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-3 py-2 border">Description</th>
                    <th class="px-3 py-2 border">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                    <tr>
                        <td class="px-3 py-2 border">{{ $log->description }}</td>
                        <td class="px-3 py-2 border">{{ $log->created_at->format('F j, Y h:i A') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
