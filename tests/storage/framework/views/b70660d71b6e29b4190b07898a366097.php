<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-4">My Schedule</h1>

    <!--[if BLOCK]><![endif]--><?php if($schedules->isEmpty()): ?>
        <p>No schedule assigned to your section.</p>
    <?php else: ?>
        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="px-4 py-2 border">Subject</th>
                    <th class="px-4 py-2 border">Instructor</th>
                    <th class="px-4 py-2 border">Day</th>
                    <th class="px-4 py-2 border">Time</th>
                </tr>
            </thead>
            <tbody>
    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td class="px-4 py-2 border"><?php echo e($schedule->subject); ?></td>
            <td class="px-4 py-2 border"><?php echo e($schedule->instructor_name ?? 'N/A'); ?></td>
            <td class="px-4 py-2 border"><?php echo e(ucfirst($schedule->day)); ?></td>
            <td class="px-4 py-2 border">
                <?php echo e(\Carbon\Carbon::parse($schedule->start_time)->format('h:i A')); ?>

                -
                <?php echo e(\Carbon\Carbon::parse($schedule->end_time)->format('h:i A')); ?>

            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
</tbody>

        </table>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH C:\xampp\htdocs\student-portal\resources\views/livewire/student/schedule.blade.php ENDPATH**/ ?>