<?php

namespace App\Providers;

use App\Models\Team;
use App\Models\Booking;
use App\Models\Content;
use App\Models\Invoice;
use App\Policies\TeamPolicy;
use App\Models\PersonCompany;
use App\Policies\BookingPolicy;
use App\Policies\ContentPolicy;
use App\Policies\InvoicePolicy;
use App\Policies\PersonCompanyPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Booking::class => BookingPolicy::class,
        Content::class => ContentPolicy::class,
        Invoice::class => InvoicePolicy::class,
        PersonCompany::class => PersonCompanyPolicy::class,
        Team::class => TeamPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
