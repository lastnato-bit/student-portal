<div>
    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $holidays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $holiday): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><?php echo e($holiday['title'] ?? 'No title'); ?></h5>
                <p class="card-text"><?php echo e($holiday['description'] ?? 'No description'); ?></p>
                <p class="card-text">
                    <small class="text-muted">
                        <?php echo e(isset($holiday['date']) ? \Carbon\Carbon::parse($holiday['date'])->toFormattedDateString() : 'No date'); ?>

                    </small>
                </p>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH C:\xampp\htdocs\student-portal\resources\views/livewire/student/holidays.blade.php ENDPATH**/ ?>