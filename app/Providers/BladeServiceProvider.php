<?php

namespace App\Providers;

use App\Tag;
use App\Post;
use App\Category;
use App\Models\Order;
use App\Enums\OrderStatus;
use App\Models\ServiceType;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot()
  {
    View::composer('admin.layouts.main', function ($view) {

      $breadcumb = [
        [
          "name" => "Dashboard",
          "url" => route("admin.home"),
          "icon" => "fa fa-dashboard"
        ],
      ];

      $paths = request()->segments();
      if (count($paths) > 1) {
        foreach ($paths as $key => $path) {
          if ($key == 1)
            $breadcumb[] = [
              "name" => ucfirst($path),
              "url" => request()->getBaseUrl() . "/" . $paths[0] . "/" . $paths[$key],
              'icon' => config("custom.admin." . $path . ".icon")
            ];
          elseif ($key == 2)
            $breadcumb[] = [
              "name" => ucfirst($path),
              "url" => request()->getBaseUrl() . "/" . $paths[0] . "/" . $paths[1] . "/" . $paths[$key],
              'icon' => config("custom.admin." . $path . ".icon")
            ];
        }
      }

      $view->with('breadcumbs', $breadcumb);
    });

    View::composer(['admin.layouts.topbar', 'admin.pages.users.profile'], function ($view) {
      $user = auth()->user();
      $view->with([
        'AUTH_USER' => $user,
      ]);
    });

  }
}
