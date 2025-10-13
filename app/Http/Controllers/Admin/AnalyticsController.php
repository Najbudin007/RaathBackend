<?php

namespace App\Http\Controllers\Admin;

use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;
use App\Http\Controllers\Controller;

class AnalyticsController extends Controller
{
    public function dashboard()
    {
        // Fetch data for different metrics
        $visitors = Analytics::fetchTotalVisitorsAndPageViews(Period::days(30));
        $topPages = Analytics::fetchMostVisitedPages(Period::days(30));
        $userTypes = Analytics::fetchUserTypes(Period::days(30));
        $trafficSources = Analytics::fetchTopReferrers(Period::days(30));
        $deviceCategories = Analytics::fetchTopBrowsers(Period::days(30));

        return view('admin.pages.google_analytic', compact(
            'visitors',
            'topPages',
            'userTypes',
            'trafficSources',
            'deviceCategories'
        ));
    }
}