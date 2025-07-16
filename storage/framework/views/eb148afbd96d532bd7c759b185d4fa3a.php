<div class="p-4">
    <h2 class="text-xl font-semibold mb-4 text-gray-800">🎉 Holidays</h2>

    <div class="overflow-x-auto rounded-lg shadow-md">
        <table class="w-full table-auto border-collapse bg-white text-sm">
            <thead class="bg-indigo-600 text-white">
                <tr>
                    <th class="text-left px-4 py-3">Date</th>
                    <th class="text-left px-4 py-3">Holiday</th>
                </tr>
            </thead>
            <tbody>
                <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $holidays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $holiday): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-2 text-gray-700">
                            <?php echo e(\Carbon\Carbon::parse($holiday['date'])->format('M d, Y')); ?>

                        </td>
                        <td class="px-4 py-2 font-medium text-gray-800">
                            <?php echo e($holiday['title']); ?>

                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="2" class="px-4 py-4 text-center text-gray-500">
                            No holidays found.
                        </td>
                    </tr>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </tbody>
        </table>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\student-portal\resources\views/livewire/student/holidays.blade.php ENDPATH**/ ?>