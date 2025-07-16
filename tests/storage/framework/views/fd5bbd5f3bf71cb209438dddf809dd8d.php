<div class="bg-white shadow rounded p-6">
    <h2 class="text-xl font-bold mb-4">🧾 My Activity Logs</h2>

    <!--[if BLOCK]><![endif]--><?php if($logs->isEmpty()): ?>
        <p class="text-gray-500">No recent activity found.</p>
    <?php else: ?>
        <table class="w-full text-sm table-auto border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-3 py-2 border">Description</th>
                    <th class="px-3 py-2 border">Date</th>
                </tr>
            </thead>
            <tbody>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="px-3 py-2 border"><?php echo e($log->description); ?></td>
                        <td class="px-3 py-2 border"><?php echo e($log->created_at->format('F j, Y h:i A')); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </tbody>
        </table>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH C:\xampp\htdocs\student-portal\resources\views/livewire/student/activity-logs.blade.php ENDPATH**/ ?>