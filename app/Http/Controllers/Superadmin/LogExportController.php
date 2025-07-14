<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Spatie\Activitylog\Models\Activity;

class LogExportController extends Controller
{
    public function export()
    {
        $logs = Activity::latest()->get();
        $filename = 'activity_logs_' . now()->format('Y_m_d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($logs) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'User', 'Action', 'Timestamp']);

            foreach ($logs as $log) {
                fputcsv($handle, [
                    $log->id,
                    $log->causer?->name ?? 'System', // Spatie uses `causer`
                    $log->description,
                    $log->created_at,
                ]);
            }

            fclose($handle);
        };

        return Response::stream($callback, 200, $headers);
    }
}
