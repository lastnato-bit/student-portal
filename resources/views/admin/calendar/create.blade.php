<form method="POST" action="{{ route('admin.calendar.store') }}">
    @csrf
    <input type="text" name="title" placeholder="Event Title" required>
    <textarea name="description" placeholder="Description"></textarea>
    <input type="datetime-local" name="start" required>
    <input type="datetime-local" name="end" required>
    <button type="submit">Add Event</button>
</form>
