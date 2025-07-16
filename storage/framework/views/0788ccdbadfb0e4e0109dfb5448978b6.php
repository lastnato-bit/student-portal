<div class="p-4">
    <h1 class="text-xl font-bold mb-4">📊 My Grades</h1>

    <!--[if BLOCK]><![endif]--><?php if($grades->isEmpty()): ?>
        <p>No grades available yet.</p>
    <?php else: ?>
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2">Subject</th>
                    <th class="px-4 py-2">Instructor</th>
                    <th class="px-4 py-2">Semester</th>
                    <th class="px-4 py-2">School Year</th>
                    <th class="px-4 py-2">Grade</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="px-4 py-2">
                            <?php echo e($grade->classSchedule?->subject?->name ?? 'N/A'); ?>

                        </td>
                        <td class="px-4 py-2">
                            <?php echo e($grade->classSchedule?->instructor?->full_name ?? 'N/A'); ?>

                        </td>
                        <td class="px-4 py-2"><?php echo e($grade->semester); ?></td>
                        <td class="px-4 py-2"><?php echo e($grade->school_year); ?></td>
                        <td class="px-4 py-2"><?php echo e($grade->grade); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </tbody>
        </table>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH C:\xampp\htdocs\student-portal\resources\views/livewire/student/grades.blade.php ENDPATH**/ ?>