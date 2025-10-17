<?php

namespace App\Http\Controllers\Admin;

use App\Filepath;
use App\Enums\StatusEnum;
use App\Models\Portfolio;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PortfolioCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\PortfolioRequest;

class PortfolioController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $portfolios = Portfolio::with('category')->latest()->get();

        return view('admin.pages.portfolios.index',compact('portfolios'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statusOptions = StatusEnum::lists();
        $categories = PortfolioCategory::pluck('id','title');
        return view('admin.pages.portfolios.create',compact('statusOptions','categories'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Portfolio\PortfolioRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PortfolioRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('feature_image')) {
            $data['feature_image'] = $request->file('feature_image')->store(Filepath::PORTFOLIO);
        }
        Portfolio::create($data);
        
        $notification = Str::toastMsg(config('custom.msg.create'),'success');

        return redirect()->route('admin.portfolios.index')->with($notification);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function show(Portfolio $portfolio)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PortfolioRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function edit(Portfolio $portfolio)
    {
        $statusOptions = StatusEnum::lists();
        $categories = PortfolioCategory::pluck('id','title');
        return view('admin.pages.portfolios.edit',compact('portfolio','statusOptions','categories'));
    }
    
    public function update(PortfolioRequest $request, Portfolio $portfolio)
    {
        $data = $request->validated();
        if ($request->hasFile('feature_image')) {
            if ($portfolio->feature_image) {
                Storage::delete($portfolio->feature_image);
            }
            $data['feature_image'] = $request->file('feature_image')->store(Filepath::PORTFOLIO);
        }
        $portfolio->update($data);
        $notification = Str::toastMsg(config('custom.msg.update'),'success');
        return redirect()->route('admin.portfolios.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Portfolio $portfolio)
    {
        try {
            // Delete the feature image if it exists
            if ($portfolio->feature_image) {
                Storage::delete($portfolio->feature_image);
            }
            
            // Delete the portfolio record
            $portfolio->delete();

            // Return JSON response for AJAX requests
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Portfolio deleted successfully!'
                ]);
            }

            // Return redirect for regular requests
            $notification = Str::toastMsg(config('custom.msg.delete'),'success');
            return redirect()->route('admin.portfolios.index')->with($notification);
            
        } catch (\Exception $e) {
            // Return JSON response for AJAX requests
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete portfolio: ' . $e->getMessage()
                ], 500);
            }

            // Return redirect for regular requests
            return redirect()->back()->with('error', 'Failed to delete portfolio: ' . $e->getMessage());
        }
    }

}