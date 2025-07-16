<x-filament::page>
    <div class="space-y-6">

        {{-- Archived Students --}}
        <x-filament::section heading="Archived Students">
            <x-filament::card>
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($archivedStudents as $student)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $student->user->fullname ?? 'N/A' }}</td>
                                <td class="px-4 py-2">
                                    <x-filament::button wire:click="restoreRecord('Student', {{ $student->id }})">Restore</x-filament::button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="px-4 py-2 text-gray-500">No archived students.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </x-filament::card>
        </x-filament::section>

        {{-- Archived Subjects --}}
        <x-filament::section heading="Archived Subjects">
            <x-filament::card>
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-100"><tr><th class="px-4 py-2">Name</th><th class="px-4 py-2">Actions</th></tr></thead>
                    <tbody>
                        @forelse($archivedSubjects as $subject)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $subject->name }}</td>
                                <td class="px-4 py-2"><x-filament::button wire:click="restoreRecord('Subject', {{ $subject->id }})">Restore</x-filament::button></td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="px-4 py-2 text-gray-500">No archived subjects.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </x-filament::card>
        </x-filament::section>

        {{-- Archived Grades --}}
        <x-filament::section heading="Archived Grades">
            <x-filament::card>
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-100"><tr><th class="px-4 py-2">Grade ID</th><th class="px-4 py-2">Actions</th></tr></thead>
                    <tbody>
                        @forelse($archivedGrades as $grade)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $grade->id }}</td>
                                <td class="px-4 py-2"><x-filament::button wire:click="restoreRecord('Grade', {{ $grade->id }})">Restore</x-filament::button></td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="px-4 py-2 text-gray-500">No archived grades.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </x-filament::card>
        </x-filament::section>

        {{-- Archived Class Schedules --}}
        <x-filament::section heading="Archived Class Schedules">
            <x-filament::card>
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-100"><tr><th class="px-4 py-2">Schedule ID</th><th class="px-4 py-2">Actions</th></tr></thead>
                    <tbody>
                        @forelse($archivedSchedules as $schedule)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $schedule->id }}</td>
                                <td class="px-4 py-2"><x-filament::button wire:click="restoreRecord('ClassSchedule', {{ $schedule->id }})">Restore</x-filament::button></td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="px-4 py-2 text-gray-500">No archived schedules.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </x-filament::card>
        </x-filament::section>

        {{-- Loop: Holidays, Academic Periods, etc --}}
        @foreach ([
            'Holidays' => $archivedHolidays ?? [],
            'Academic Periods' => $archivedPeriods ?? [],
            'Courses' => $archivedCourses ?? [],
            'Departments' => $archivedDepartments ?? [],
            'Instructors' => $archivedInstructors ?? [],
            'Sections' => $archivedSections ?? [],
            'Announcements' => $archivedAnnouncements ?? [],
            'Email Templates' => $archivedEmails ?? [],
        ] as $label => $items)

            <x-filament::section :heading="'Archived ' . $label">
                <x-filament::card>
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-100"><tr><th class="px-4 py-2">ID</th><th class="px-4 py-2">Actions</th></tr></thead>
                        <tbody>
                            @forelse($items as $item)
                                <tr class="border-t">
                                    <td class="px-4 py-2">{{ $item->id }}</td>
                                    <td class="px-4 py-2">
                                        <x-filament::button wire:click="restoreRecord('{{ Str::studly(Str::singular($label)) }}', {{ $item->id }})">Restore</x-filament::button>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="2" class="px-4 py-2 text-gray-500">No archived {{ Str::lower($label) }}.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </x-filament::card>
            </x-filament::section>

        @endforeach

        {{-- Archived Admin Users --}}
        <x-filament::section heading="Archived Admin Users">
            <x-filament::card>
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($archivedAdminUsers as $admin)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $admin->fullname ?? $admin->name }}</td>
                                <td class="px-4 py-2">{{ $admin->email }}</td>
                                <td class="px-4 py-2">
                                    <x-filament::button wire:click="restoreRecord('User', {{ $admin->id }})">Restore</x-filament::button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-4 py-2 text-gray-500">No archived admin users.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </x-filament::card>
        </x-filament::section>

    </div>
</x-filament::page>
