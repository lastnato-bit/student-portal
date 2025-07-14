@extends('layouts.auth')

@section('content')
    <h2 class="text-2xl font-bold mb-6 text-center">Admin Forgot Password</h2>

    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 text-sm text-red-500">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.password.email') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="block text-sm font-bold mb-2 text-gray-700">Email Address</label>
            <input id="email" type="email" name="email" required autofocus
                   class="w-full border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:outline-none focus:ring focus:ring-indigo-500">
        </div>

        <div class="mt-6">
            <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Send Confirmation Link
            </button>
        </div>
    </form>
@endsection
