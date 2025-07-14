<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h1 class="text-2xl font-semibold mb-4">Superadmin Dashboard</h1>
            <p>Welcome, {{ Auth::user()->name }}!</p>

            <div class="mt-6">
                <a href="{{ route('profile.show') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-700 transition">
                    Manage Profile & 2FA
                </a>
            </div>
        </div>
    </div>
</div>
