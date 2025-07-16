<div class="p-6">
    <h2 class="text-2xl font-semibold mb-4">👤 Student Profile</h2>

    <div class="grid grid-cols-2 gap-4 text-sm">
        <div><strong>Name:</strong> <?php echo e($student->user->name ?? 'N/A'); ?></div>
        <div><strong>Student Number:</strong> <?php echo e($student->student_number ?: 'N/A'); ?></div>
        <div><strong>Gender:</strong> <?php echo e($student->gender ?: 'N/A'); ?></div>
        <div><strong>Birthdate:</strong> 
            <?php echo e($student->birthdate ? \Carbon\Carbon::parse($student->birthdate)->format('F d, Y') : 'N/A'); ?>

        </div>
        <div><strong>Contact Number:</strong> <?php echo e($student->contact_number ?: 'N/A'); ?></div>
        <div><strong>Email:</strong> <?php echo e($student->user->email ?? 'N/A'); ?></div>
        <div><strong>Address:</strong> <?php echo e($student->address ?: 'N/A'); ?></div>
        <div><strong>Department:</strong> <?php echo e($student->department->name ?? 'N/A'); ?></div>
        <div><strong>Course:</strong> <?php echo e($student->course ?: 'N/A'); ?></div>
        <div><strong>Year Level:</strong> <?php echo e($student->year_level ?: 'N/A'); ?></div>
        <div><strong>Section:</strong> <?php echo e($student->section->name ?? 'N/A'); ?></div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\student-portal\resources\views/livewire/student/profile.blade.php ENDPATH**/ ?>