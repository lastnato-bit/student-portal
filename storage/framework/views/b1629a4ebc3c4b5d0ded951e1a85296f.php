<div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2 flex items-center gap-2">
        👤 <span>Student Profile</span>
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8 text-sm text-gray-700">
        <div>
            <span class="font-semibold">Name:</span>
            <?php echo e($student->user->lastname); ?>, <?php echo e($student->user->firstname); ?> <?php echo e($student->user->middlename ?? ''); ?>

        </div>
        <div>
            <span class="font-semibold">Student Number:</span>
            <?php echo e($student->student_number ?: 'N/A'); ?>

        </div>

        <div>
            <span class="font-semibold">Gender:</span>
            <?php echo e(ucfirst($student->gender ?: 'N/A')); ?>

        </div>
        <div>
            <span class="font-semibold">Birthdate:</span>
            <?php echo e($student->birthdate ? \Carbon\Carbon::parse($student->birthdate)->format('F d, Y') : 'N/A'); ?>

        </div>

        <div>
            <span class="font-semibold">Contact Number:</span>
            <?php echo e($student->contact_number ?: 'N/A'); ?>

        </div>
        <div>
            <span class="font-semibold">Email:</span>
            <?php echo e($student->user->email ?? 'N/A'); ?>

        </div>

        <div class="md:col-span-2">
            <span class="font-semibold">Address:</span>
            <?php echo e($student->address ?: 'N/A'); ?>

        </div>

        <div>
            <span class="font-semibold">Department:</span>
            <?php echo e($student->department->name ?? 'N/A'); ?>

        </div>
        <div>
    <span class="font-semibold">Course:</span>
    <?php echo e($student->course?->name ?? 'N/A'); ?>

</div>


        <div>
            <span class="font-semibold">Year Level:</span>
            <?php echo e($student->year_level ?: 'N/A'); ?>

        </div>
        <div>
            <span class="font-semibold">Section:</span>
            <?php echo e($student->section->name ?? 'N/A'); ?>

        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\student-portal\resources\views/livewire/student/profile.blade.php ENDPATH**/ ?>