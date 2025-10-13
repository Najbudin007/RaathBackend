<?php

namespace App\Providers;

use App\Mixins\DateMixins;
use App\Mixins\OtherMixins;
use Illuminate\Support\Str;
use App\Mixins\ToastMsgMixin;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFour();
        
        Str::mixin(new DateMixins());
        Str::mixin(new ToastMsgMixin());
        Str::mixin(new OtherMixins());
    }
}
