<div class="p-4">
    <h1 class="text-xl font-bold mb-4">📊 My Grades</h1>

    <!--[if BLOCK]><![endif]--><?php if($grades->isEmpty()): ?>
        <p>No grades available yet.</p>
    <?php else: ?>
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">Subject</th>
                    <th class="border px-4 py-2">Grade</th>
                    <th class="border px-4 py-2">Semester</th>
                    <th class="border px-4 py-2">School Year</th>
                </tr>
            </thead>
            <tbody>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="border px-4 py-2"><?php echo e($grade->subject); ?></td>
                        <td class="border px-4 py-2"><?php echo e($grade->grade); ?></td>
                        <td class="border px-4 py-2"><?php echo e($grade->semester ?? 'N/A'); ?></td>
                        <td class="border px-4 py-2"><?php echo e($grade->school_year ?? 'N/A'); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </tbody>
        </table>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH C:\xampp\htdocs\student-portal\resources\views/livewire/student/grades.blade.php ENDPATH**/ ?>