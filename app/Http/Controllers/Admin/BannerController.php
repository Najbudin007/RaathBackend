<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Models\Banner;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
// use App\Traits\ImageTool;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\BannerRequest;

class BannerController extends Controller
{
    // use ImageTool;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Banner::query();
        $filter = $this->filterQuery($query);
        $banners = $filter->latest('id')->paginate(15);
        return view('admin.pages.banners.index',compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bannerStatus = StatusEnum::lists();
        return view('admin.pages.banners.create',compact('bannerStatus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BannerRequest $request)
    {
        Banner::create([
            'title' => $request->title,
            'url' => $request->url,
            'status' => $request->status,
            'description' => $request->description,
            'image' => $request->file('image')->store('banners','public')
        ]);
        $notification = Str::toastMsg(config('custom.msg.create'),'success');
        return redirect()->route('admin.banners.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        // $banner->image = $this->imageResize($banner->image, 500,200);
        $bannerStatus = StatusEnum::lists();
        return view('admin.pages.banners.edit',compact('banner','bannerStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(BannerRequest $request, Banner $banner)
    {
        
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'status'      => $request->status,
            'url'      => $request->url,
        ];
        
        if($request->hasFile('image')) {
            $imgPath = $request->file('image')->store('banners','public');
            $data += ['image' => $imgPath];

            if(Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }


        }

        $banner->update($data);

        $notification = Str::toastMsg(config('custom.msg.update'),'success');
        return redirect()->route('admin.banners.index')->with($notification);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();

        if($banner->image != null && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }
        $notification = Str::toastMsg(config('custom.msg.delete'),'success');
        $notification = Str::toastMsg(config('custom.msg.delete'),'success');
    }

    public function getPriority()
    {
        $banners = Banner::orderBy('priority','asc')->get();
        return view('admin.pages.banners.priority',compact('banners'));
    }

    public function setPriority(Request $request)
    {
        $banners = array_filter($request->banners,function($banner) {
          return $banner !=null;
        });

        $sortableBanner = new Banner;
        foreach ($banners as $index => $banner) {
          $sortableBanner->where('id', $banner)->update(
              [
                  'priority' => $index,
                  'id' => $banner
              ]
            );
        }

        return response()->json(['message' => 'Category sorted successfully'],200);
    }

    private function filterQuery($query)
    {
        if(request()->filled('title')) {
             $query->where('title','like', '%'. request()->title.'%');
        }

        return $query;
    }
}
