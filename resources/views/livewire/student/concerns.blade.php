<div>
    <h2 class="text-xl font-bold mb-4">Submit a Concern</h2>

    @if (session()->has('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-4">
        <div>
            <label class="block text-sm font-medium">Concern Category</label>
            <select wire:model.defer="category" class="w-full border px-3 py-2 rounded" required>
                <option value="">Select a category</option>
                <option value="Schedule">Schedule</option>
                <option value="Grades">Grades</option>
                <option value="Enrollment">Enrollment</option>
                <option value="Profile">Profile</option>
                <option value="Others">Others</option>
            </select>
            @error('category') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Message</label>
            <textarea wire:model.defer="message" class="w-full border px-3 py-2 rounded" rows="5" required></textarea>
            @error('message') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Submit
        </button>
    </form>

    <h3 class="text-lg font-semibold mt-8 mb-2">Your Submitted Concerns</h3>
    <div class="space-y-3">
        @forelse ($concerns as $concern)
            <div class="bg-white p-4 border rounded shadow">
                <p class="font-semibold">Category: {{ $concern->category }}</p>
                <p class="text-gray-700 mt-1">{{ $concern->message }}</p>
                <p class="text-sm mt-2 text-gray-600">
                    Status: <span class="font-medium">{{ $concern->status }}</span>
                </p>
                @if ($concern->admin_response)
                    <div class="mt-2 p-2 bg-gray-100 border rounded text-sm text-gray-700">
                        <strong>Admin Response:</strong> {{ $concern->admin_response }}
                    </div>
                @endif
            </div>
        @empty
            <p class="text-sm text-gray-500">No concerns submitted yet.</p>
        @endforelse
    </div>
</div>
