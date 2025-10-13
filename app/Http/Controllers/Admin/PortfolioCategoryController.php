<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PortfolioCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PortfolioCategoryRequest;

class PortfolioCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $portfoliocategories = PortfolioCategory::latest()->get();

        return view('admin.pages.portfolio_categories.index',compact('portfoliocategories'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statusOptions = StatusEnum::lists();
        return view('admin.pages.portfolio_categories.create',compact('statusOptions'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PortfolioCategory\PortfolioCategoryRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PortfolioCategoryRequest $request)
    {
        PortfolioCategory::create($request->validated());
        
        $notification = Str::toastMsg(config('custom.msg.create'),'success');

        return redirect()->route('admin.portfolio_categories.index')->with($notification);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PortfolioCategory  $portfolioCategory
     * @return \Illuminate\Http\Response
     */
    public function show(PortfolioCategory $portfolioCategory)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PortfolioCategoryRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PortfolioCategory  $portfolioCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(PortfolioCategory $portfolioCategory)
    {
        $statusOptions = StatusEnum::lists();
        return view('admin.pages.portfolio_categories.edit',compact('portfolioCategory','statusOptions'));
    }
    
    public function update(PortfolioCategoryRequest $request, PortfolioCategory $portfolioCategory)
    {
        $portfolioCategory->update($request->validated());
        $notification = Str::toastMsg(config('custom.msg.update'),'success');
        return redirect()->route('admin.portfolio_categories.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PortfolioCategory  $portfolioCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(PortfolioCategory $portfolioCategory)
    {
        $portfolioCategory->delete();
        $notification = Str::toastMsg(config('custom.msg.delete'),'success');
        return response($notification);
    }

}