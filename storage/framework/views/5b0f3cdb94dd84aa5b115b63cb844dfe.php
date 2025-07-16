<div>
    <h2 class="text-xl font-bold mb-4">Submit a Concern</h2>

    <!--[if BLOCK]><![endif]--><?php if(session()->has('success')): ?>
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <?php if(session()->has('error')): ?>
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <form wire:submit.prevent="submit" class="space-y-4">
        <div>
            <label class="block text-sm font-medium">Concern Category</label>
            <select wire:model.defer="category" class="w-full border px-3 py-2 rounded" required>
                <option value="">Select a category</option>
                <option value="Schedule">Schedule</option>
                <option value="Grades">Grades</option>
                <option value="Enrollment">Enrollment</option>
                <option value="Profile">Profile</option>
                <option value="Others">Others</option>
            </select>
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-600 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <div>
            <label class="block text-sm font-medium">Message</label>
            <textarea wire:model.defer="message" class="w-full border px-3 py-2 rounded" rows="5" required></textarea>
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-600 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Submit
        </button>
    </form>

    <h3 class="text-lg font-semibold mt-8 mb-2">Your Submitted Concerns</h3>
    <div class="space-y-3">
        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $concerns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $concern): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white p-4 border rounded shadow">
                <p class="font-semibold">Category: <?php echo e($concern->category); ?></p>
                <p class="text-gray-700 mt-1"><?php echo e($concern->message); ?></p>
                <p class="text-sm mt-2 text-gray-600">
                    Status: <span class="font-medium"><?php echo e($concern->status); ?></span>
                </p>
                <!--[if BLOCK]><![endif]--><?php if($concern->admin_response): ?>
                    <div class="mt-2 p-2 bg-gray-100 border rounded text-sm text-gray-700">
                        <strong>Admin Response:</strong> <?php echo e($concern->admin_response); ?>

                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-sm text-gray-500">No concerns submitted yet.</p>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\student-portal\resources\views/livewire/student/concerns.blade.php ENDPATH**/ ?>