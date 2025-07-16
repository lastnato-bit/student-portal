<?php if (isset($component)) { $__componentOriginald489e48d6214ecaf87e4b6a8ce684ad1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald489e48d6214ecaf87e4b6a8ce684ad1 = $attributes; } ?>
<?php $component = Filament\View\LegacyComponents\Widget::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Filament\View\LegacyComponents\Widget::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="rounded-xl overflow-hidden shadow-xl bg-gradient-to-r from-lime-300 via-lime-200 to-lime-100 border border-lime-400/50">
        <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-6 px-6 py-8">

            
            <div class="max-w-md text-gray-900">
                <h1 class="text-3xl font-bold leading-tight">
                    👋 Welcome, <?php echo e(Auth::user()->firstname); ?> <?php echo e(Auth::user()->middlename); ?> <?php echo e(Auth::user()->lastname); ?>

                </h1>
                <p class="mt-2 text-sm font-medium text-green-800">
                    🧑‍💼 Role:
                    <span class="capitalize underline decoration-green-700/40 underline-offset-4">
                        <?php echo e(Auth::user()->getRoleNames()->first() ?? 'N/A'); ?>

                    </span>
                </p>
                <p class="mt-3 text-sm text-green-700">
                    Here's a quick overview of your system at a glance.
                </p>
            </div>

            
            <div class="flex justify-center md:justify-end">
                <div class="text-[5rem] opacity-80">📈</div>
            </div>

        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald489e48d6214ecaf87e4b6a8ce684ad1)): ?>
<?php $attributes = $__attributesOriginald489e48d6214ecaf87e4b6a8ce684ad1; ?>
<?php unset($__attributesOriginald489e48d6214ecaf87e4b6a8ce684ad1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald489e48d6214ecaf87e4b6a8ce684ad1)): ?>
<?php $component = $__componentOriginald489e48d6214ecaf87e4b6a8ce684ad1; ?>
<?php unset($__componentOriginald489e48d6214ecaf87e4b6a8ce684ad1); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\student-portal\resources\views/filament/admin/widgets/welcome-admin.blade.php ENDPATH**/ ?>