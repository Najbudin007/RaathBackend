<?php

namespace App\Http\Controllers\Admin;


use App\Models\Blog;
use App\Models\Team;
use App\Models\User;
use App\Models\Client;
use App\Models\Service;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use App\Models\EmailSubscriber;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [
            'users' => EmailSubscriber::count(),
            'posts' => Blog::count(),
            'teams' => Team::count(),
            'portfolios' => Portfolio::count(),
            'services' => Service::count(),
            'clients' => Client::count(),
        ];
        return view('admin.dashboard', $data);
    }
}
