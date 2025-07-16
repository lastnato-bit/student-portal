<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen text-gray-800" x-data="{ tab: 'dashboard', userMenu: false }">

    <!-- Top Bar -->
    <nav class="bg-white shadow-md px-6 py-4 flex justify-between items-center border-b">
        <h1 class="text-2xl font-semibold tracking-wide">🎓 Student Portal</h1>

        <!-- User Menu -->
        <div class="relative" @click.away="userMenu = false">
            <button @click="userMenu = !userMenu" class="flex items-center text-sm focus:outline-none hover:text-blue-600 transition">
                <span class="mr-2 font-medium"><?php echo e(Auth::user()->name); ?></span>
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="userMenu" x-transition class="absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg z-50">
                <a href="<?php echo e(route('profile.show')); ?>" class="block px-4 py-2 text-sm hover:bg-gray-100">👤 Profile</a>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">🚪 Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Layout -->
    <div class="flex h-[calc(100vh-72px)]">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r shadow-sm p-4 space-y-2">
            <ul class="space-y-1 text-[15px] font-medium">
                <li><button @click="tab = 'dashboard'" :class="tab === 'dashboard' ? 'bg-blue-100 text-blue-600' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">📊 Dashboard</button></li>
                <li><button @click="tab = 'grades'" :class="tab === 'grades' ? 'bg-blue-100 text-blue-600' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">📚 Grades</button></li>
                <li><button @click="tab = 'schedule'" :class="tab === 'schedule' ? 'bg-blue-100 text-blue-600' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">🗓️ Schedule</button></li>
                <li><button @click="tab = 'profile'" :class="tab === 'profile' ? 'bg-blue-100 text-blue-600' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">👤 Profile</button></li>
                <li><button @click="tab = 'logs'" :class="tab === 'logs' ? 'bg-blue-100 text-blue-600' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">📝 Activity Logs</button></li>
                <li><button @click="tab = 'report'" :class="tab === 'report' ? 'bg-blue-100 text-blue-600' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">📄 Grade Report</button></li>
                <li><button @click="tab = 'holidays'" :class="tab === 'holidays' ? 'bg-blue-100 text-blue-600' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">🎉 Holidays</button></li>
                <li><button @click="tab = 'enrollment'" :class="tab === 'enrollment' ? 'bg-blue-100 text-blue-600' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">🧾 Enrollment Info</button></li>
                <li><button @click="tab = 'announcements'" :class="tab === 'announcements' ? 'bg-blue-100 text-blue-600' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">📢 Announcements</button></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8 bg-gray-50 overflow-y-auto">

            <!-- Dashboard -->
            <div x-show="tab === 'dashboard'">
                <h2 class="text-2xl font-bold mb-2">Welcome, <?php echo e(Auth::user()->name); ?>!</h2>
                <p class="text-gray-600">Use the sidebar to navigate through your academic info and tools.</p>
            </div>

            <!-- Grades -->
            <div x-show="tab === 'grades'">
                
                <div class="mb-4 text-right">
                    <a href="<?php echo e(route('student.grades.pdf')); ?>"
                       class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow transition">
                        📥 Download PDF
                    </a>
                </div>

                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('student.grades');

$__html = app('livewire')->mount($__name, $__params, 'lw-3724528818-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            </div>

            <!-- Schedule -->
            <div x-show="tab === 'schedule'">
                <h2 class="text-xl font-semibold mb-2">🗓️ Schedule</h2>
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('student.schedule');

$__html = app('livewire')->mount($__name, $__params, 'lw-3724528818-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            </div>

            <!-- Profile -->
            <div x-show="tab === 'profile'">
                
                <p class="text-gray-600">Your profile information goes here.</p>
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('student.profile');

$__html = app('livewire')->mount($__name, $__params, 'lw-3724528818-2', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            </div>

            <!-- Activity Logs -->
            <div x-show="tab === 'logs'">
                
                <p class="text-gray-600">Recent login and activity logs will be listed here.</p>
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('student.activity-logs');

$__html = app('livewire')->mount($__name, $__params, 'lw-3724528818-3', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            </div>

            <!-- Grade Report -->
            <div x-show="tab === 'report'">
                <h2 class="text-xl font-semibold mb-2">📄 Grade Report</h2>
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('student.grade-report');

$__html = app('livewire')->mount($__name, $__params, 'lw-3724528818-4', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            </div>

            <!-- Holidays -->
            <div x-show="tab === 'holidays'">
                <h2 class="text-xl font-semibold mb-2">🎉 Holidays</h2>
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('student.holidays');

$__html = app('livewire')->mount($__name, $__params, 'lw-3724528818-5', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            </div>

            <!-- Enrollment Info -->
            <div x-show="tab === 'enrollment'">
                
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('student.enrollment-info');

$__html = app('livewire')->mount($__name, $__params, 'lw-3724528818-6', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            </div>

            <!-- Announcements -->
            <div x-show="tab === 'announcements'">
                <h2 class="text-xl font-semibold mb-2">📢 Announcements</h2>
                <?php
                    $announcements = \App\Models\Announcement::whereIn('visible_to', ['student', 'all'])->orderByDesc('published_at')->get();
                ?>

                <?php $__empty_1 = true; $__currentLoopData = $announcements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="bg-white p-4 rounded shadow mb-3">
                        <h3 class="text-lg font-bold"><?php echo e($announcement->title); ?></h3>
                        <p class="text-gray-600 text-sm mb-2">
                            <?php echo e(\Carbon\Carbon::parse($announcement->published_at)->format('F d, Y')); ?>

                        </p>
                        <p class="text-gray-700"><?php echo e($announcement->content); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-600">No announcements available.</p>
                <?php endif; ?>
            </div>

        </main>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\student-portal\resources\views/livewire/student/dashboard.blade.php ENDPATH**/ ?>