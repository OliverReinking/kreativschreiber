<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Laravel\Jetstream\Jetstream;

class DashboardCustomerController extends Controller
{
    public function customer_index()
    {
        return Inertia::render('Application/Customer/Dashboard');
    }
    //
    public function customer_no_permission($message)
    {
        return Inertia::render('Application/Customer/NoPermission', [
            'message' => $message,
        ]);
    }
    //
    public function customer_profile(Request $request)
    {
        return Inertia::render('Application/Customer/Profile', [
            'sessions' => ApplicationController::sessions($request)->all(),
        ]);
    }
    //
    public function customer_api_tokens_index(Request $request)
    {
        return Jetstream::inertia()->render($request, 'Application/Customer/ApiTokenManager', [
            'tokens' => $request->user()->tokens->map(function ($token) {
                return $token->toArray() + [
                    'last_used_ago' => optional($token->last_used_at)->diffForHumans(),
                ];
            }),
            'availablePermissions' => Jetstream::$permissions,
            'defaultPermissions' => Jetstream::$defaultPermissions,
        ]);
    }
    // ------------
    // Organization
    // ------------
    public function customer_organization_index()
    {
        //
        return Inertia::render('Application/Customer/OrganizationDashboard');
    }
}
