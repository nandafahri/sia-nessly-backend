<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    protected function logActivity(string $action, string $userType = 'admin')
    {
        // Ambil nama user yang sedang login, fallback ke 'System' jika tidak ada
        $userName = Auth::guard($userType)->check() ? Auth::guard($userType)->user()->name : 'System';

        ActivityLog::create([
            'action'    => $action,
            'user_type' => $userType,
            'user_name' => $userName,
        ]);
    }
}
