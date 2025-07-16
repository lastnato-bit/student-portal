<div class="space-y-6">
    <h2 class="text-2xl font-bold">🧾 Enrollment Information</h2>

    <!--[if BLOCK]><![endif]--><?php if(isset($student) && $student): ?>
        <!-- 👤 Student Profile -->
        <div class="bg-white shadow-md rounded p-6">
            <h3 class="text-lg font-semibold mb-4">👤 Student Profile</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div><strong>Name:</strong> <?php echo e($student->user->full_name ?? 'N/A'); ?></div>
                <div><strong>Student Number:</strong> <?php echo e($student->student_number ?? 'N/A'); ?></div>
                <div><strong>Gender:</strong> <?php echo e($student->gender ?? 'N/A'); ?></div>
                <div><strong>Birthdate:</strong> <?php echo e($student->birthdate ? \Carbon\Carbon::parse($student->birthdate)->toFormattedDateString() : 'N/A'); ?></div>
                <div><strong>Contact Number:</strong> <?php echo e($student->contact_number ?? 'N/A'); ?></div>
                <div><strong>Email:</strong> <?php echo e($student->user->email ?? 'N/A'); ?></div>
                <div><strong>Address:</strong> <?php echo e($student->address ?? 'N/A'); ?></div>
                <div><strong>Department:</strong> <?php echo e($student->department->name ?? 'N/A'); ?></div>
                <div><strong>Course:</strong> <?php echo e($student->course?->name ?? 'N/A'); ?></div>
                <div><strong>Year Level:</strong> <?php echo e($student->year_level ?? 'N/A'); ?></div>
                <div><strong>Section:</strong> <?php echo e($student->section->name ?? 'N/A'); ?></div>
            </div>
        </div>

        <!-- 📌 Enrollment Info -->
        <div class="bg-white shadow-md rounded p-6">
            <h3 class="text-lg font-semibold mb-4">📌 Enrollment Details</h3>
            <p><strong>School Year:</strong> <?php echo e($schoolYear ?? 'N/A'); ?></p>
            <p><strong>Semester:</strong> <?php echo e(ucfirst($semester ?? 'N/A')); ?></p>
            <p><strong>Status:</strong> <?php echo e($student->enrollment_status ?? 'Enrolled'); ?></p>
        </div>

        <!-- 🗓️ Class Schedule -->
        <div class="bg-white shadow-md rounded p-6">
            <h3 class="text-lg font-semibold mb-4">🗓️ Class Schedule</h3>

            <!--[if BLOCK]><![endif]--><?php if(isset($schedules) && $schedules->isNotEmpty()): ?>
                <table class="w-full text-sm table-auto border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-3 py-2 border text-left">Subject</th>
                            <th class="px-3 py-2 border text-left">Day</th>
                            <th class="px-3 py-2 border text-left">Time</th>
                            <th class="px-3 py-2 border text-left">Room</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="px-3 py-2 border">
                                    <?php echo e($schedule->subject->code ?? 'N/A'); ?> - <?php echo e($schedule->subject->name ?? ''); ?>

                                </td>
                                <td class="px-3 py-2 border capitalize"><?php echo e($schedule->day ?? 'N/A'); ?></td>
                                <td class="px-3 py-2 border">
                                    <?php echo e(\Carbon\Carbon::parse($schedule->start_time)->format('h:i A')); ?>

                                    -
                                    <?php echo e(\Carbon\Carbon::parse($schedule->end_time)->format('h:i A')); ?>

                                </td>
                                <td class="px-3 py-2 border"><?php echo e($schedule->room ?? 'N/A'); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-gray-500">No class schedule assigned yet.</p>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    <?php else: ?>
        <p class="text-red-600">Student information not available.</p>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH C:\xampp\htdocs\student-portal\resources\views/livewire/student/enrollment-info.blade.php ENDPATH**/ ?>