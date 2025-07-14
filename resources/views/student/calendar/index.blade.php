@extends('layouts.app') {{-- Or whatever your base layout is --}}

@section('content')
    <h2>Upcoming School Events</h2>

    @if(count($events))
        @foreach($events as $event)
            <div class="p-4 border rounded my-2">
                <strong>{{ $event->getSummary() }}</strong><br>
                <small>
                    {{ \Carbon\Carbon::parse($event->start->dateTime)->toDayDateTimeString() }}
                    –
                    {{ \Carbon\Carbon::parse($event->end->dateTime)->toDayDateTimeString() }}
                </small>
                <p>{{ $event->getDescription() }}</p>
            </div>
        @endforeach
    @else
        <p>No upcoming events found.</p>
    @endif
@endsection
