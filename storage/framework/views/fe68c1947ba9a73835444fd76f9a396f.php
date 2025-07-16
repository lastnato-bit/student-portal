<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>

    
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('favicon.ico')); ?>">

    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
</head>
<body class="bg-gray-50 min-h-screen text-gray-800"
      x-data="{ tab: 'dashboard', userMenu: false, sidebarOpen: true }">

<!-- ✅ Layout Wrapper -->
<div class="flex h-screen overflow-hidden">

    <!-- ✅ Sidebar -->
    <aside class="bg-gradient-to-b from-blue-100 to-white shadow-md w-64 transform transition-transform duration-200 ease-in-out z-40 fixed inset-y-0 left-0 lg:relative"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
        <div class="h-full p-6 overflow-y-auto">
            
            <a href="<?php echo e(route('student.dashboard')); ?>" class="flex items-center space-x-2 mb-6">
                <img src="<?php echo e(asset('logo.png')); ?>" alt="Student Portal Logo" class="h-10 w-auto">
            </a>

            
            <ul class="space-y-2 text-[15px] font-medium">
                <li><button @click="tab = 'dashboard'" :class="tab === 'dashboard' ? 'bg-blue-200 text-blue-700' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">📊 Dashboard</button></li>
                <li><button @click="tab = 'concerns'" :class="tab === 'concerns' ? 'bg-blue-200 text-blue-700' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">📨 Concerns</button></li>
                <li><button @click="tab = 'grades'" :class="tab === 'grades' ? 'bg-blue-200 text-blue-700' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">📚 Grades</button></li>
                <li><button @click="tab = 'schedule'" :class="tab === 'schedule' ? 'bg-blue-200 text-blue-700' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">🗓️ Schedule</button></li>
                <li><button @click="tab = 'profile'" :class="tab === 'profile' ? 'bg-blue-200 text-blue-700' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">👤 Profile</button></li>
                <li><button @click="tab = 'logs'" :class="tab === 'logs' ? 'bg-blue-200 text-blue-700' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">📝 Activity Logs</button></li>
                <li><button @click="tab = 'report'" :class="tab === 'report' ? 'bg-blue-200 text-blue-700' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">📄 Grade Report</button></li>
                <li><button @click="tab = 'holidays'" :class="tab === 'holidays' ? 'bg-blue-200 text-blue-700' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">🎉 Holidays</button></li>
                <li><button @click="tab = 'enrollment'" :class="tab === 'enrollment' ? 'bg-blue-200 text-blue-700' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">🧾 Enrollment Info</button></li>
                <li><button @click="tab = 'announcements'" :class="tab === 'announcements' ? 'bg-blue-200 text-blue-700' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">📢 Announcements</button></li>
            </ul>
        </div>
    </aside>

    <!-- ✅ Overlay (Mobile Only) -->
    <div class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden"
         x-show="sidebarOpen"
         x-transition.opacity
         @click="sidebarOpen = false"
         x-cloak></div>

    <!-- ✅ Main Content Area -->
    <div class="flex flex-col flex-1 min-h-screen transition-all duration-200 ease-in-out"
         :class="sidebarOpen ? 'lg:ml-64' : 'ml-0'">

        <!-- ✅ Full Width Fixed Header -->
        <header class="bg-white shadow px-6 py-4 flex justify-between items-center border-b fixed top-0 left-0 right-0 z-20 transition-all"
                :class="sidebarOpen ? 'lg:ml-64' : 'ml-0'">
            <div class="flex items-center space-x-6">
                <!-- Hamburger Toggle -->
                <button class="text-gray-600 focus:outline-none" @click="sidebarOpen = !sidebarOpen">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <!-- Brand -->
                <a href="<?php echo e(route('student.dashboard')); ?>" class="text-xl font-semibold text-blue-900 hover:underline">
                    Student Portal
                </a>
            </div>

            <!-- User Dropdown -->
            <div class="relative" @click.away="userMenu = false">
                <button @click="userMenu = !userMenu" class="flex items-center space-x-2 text-sm hover:text-blue-600 focus:outline-none">
                    <span class="font-medium"><?php echo e(Auth::user()->name); ?></span>
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="userMenu" x-transition class="absolute right-0 mt-2 w-48 bg-white border rounded shadow z-50">
                    <a href="<?php echo e(route('profile.show')); ?>" class="block px-4 py-2 text-sm hover:bg-gray-100">👤 Profile</a>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">🚪 Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <!-- ✅ Main Content with Header Padding -->
        <main class="flex-1 p-6 pt-24 overflow-y-auto bg-gray-50">
            <div class="max-w-5xl mx-auto">
                <div x-show="tab === 'dashboard'">
                    <h2 class="text-2xl font-bold mb-2">Welcome, <?php echo e(Auth::user()->name); ?>!</h2>
                    <p class="text-gray-600">Use the sidebar to navigate through your academic info and tools.</p>
                </div>
                <div x-show="tab === 'grades'"><?php
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
?></div>
                <div x-show="tab === 'schedule'"><?php
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
?></div>
                <div x-show="tab === 'profile'"><?php
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
?></div>
                <div x-show="tab === 'logs'"><?php
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
?></div>
                <div x-show="tab === 'report'"><?php
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
?></div>
                <div x-show="tab === 'holidays'"><?php
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
?></div>
                <div x-show="tab === 'concerns'" x-transition x-cloak>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('student.concerns', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-3724528818-6', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
</div>

                <div x-show="tab === 'enrollment'"><?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('student.enrollment-info');

$__html = app('livewire')->mount($__name, $__params, 'lw-3724528818-7', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?></div>
                <div x-show="tab === 'announcements'">

                    <?php
                        $announcements = \App\Models\Announcement::whereIn('visible_to', ['student', 'all'])->orderByDesc('published_at')->get();
                    ?>
                    <?php $__empty_1 = true; $__currentLoopData = $announcements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="bg-white p-4 rounded shadow mb-3">
                            <h3 class="text-lg font-bold"><?php echo e($announcement->title); ?></h3>
                            <p class="text-gray-600 text-sm mb-2"><?php echo e(\Carbon\Carbon::parse($announcement->published_at)->format('F d, Y')); ?></p>
                            <p class="text-gray-700"><?php echo e($announcement->content); ?></p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-gray-600">No announcements available.</p>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\student-portal\resources\views/livewire/student/dashboard.blade.php ENDPATH**/ ?>