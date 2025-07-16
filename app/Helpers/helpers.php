<?php

use App\Models\AcademicPeriod;

if (!function_exists('getActiveAcademicPeriod')) {
    function getActiveAcademicPeriod()
    {
        return AcademicPeriod::where('is_active', true)->first();
    }
}
