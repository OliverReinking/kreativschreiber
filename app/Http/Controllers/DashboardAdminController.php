<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Laravel\Jetstream\Jetstream;

class DashboardAdminController extends Controller
{
    //
    public function admin_index()
    {
        //
        $counts = DB::table('users')
            ->selectRaw('count(*) as users')
            ->selectRaw("count(case when is_admin = 1 then 1 end) as admins")
            ->selectRaw("count(case when is_customer = 1 then 1 end) as customers")
            ->first();

        return Inertia::render('Application/Admin/Dashboard', [
            'counts' => $counts,
        ]);
    }
    //
    public function admin_acquisitions_dashboard()
    {
        //
        return Inertia::render('Application/Admin/AcquisitionDashboard');
    }
    //
    public function admin_content_dashboard()
    {
        //
        return Inertia::render('Application/Admin/ContentDashboard');
    }
    //
    public function admin_profile(Request $request)
    {
        return Inertia::render('Application/Admin/Profile', [
            'sessions' => ApplicationController::sessions($request)->all(),
        ]);
    }
    //
    public function admin_api_tokens_index(Request $request)
    {
        return Jetstream::inertia()->render($request, 'Application/Admin/ApiTokenManager', [
            'tokens' => $request->user()->tokens->map(function ($token) {
                return $token->toArray() + [
                    'last_used_ago' => optional($token->last_used_at)->diffForHumans(),
                ];
            }),
            'availablePermissions' => Jetstream::$permissions,
            'defaultPermissions' => Jetstream::$defaultPermissions,
        ]);
    }
}
