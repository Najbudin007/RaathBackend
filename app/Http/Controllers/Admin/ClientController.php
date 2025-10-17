<?php

namespace App\Http\Controllers\Admin;

use App\Filepath;
use App\Models\Client;
use App\Enums\StatusEnum;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\ClientRequest;

class ClientController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clients = Client::get();

        return view('admin.pages.clients.index',compact('clients'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statusOptions = StatusEnum::lists();
        return view('admin.pages.clients.create',compact('statusOptions'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Client\ClientRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store(Filepath::CLIENTS);
        }

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store(Filepath::CLIENTS);
        }

        Client::create($data);

        
        $notification = Str::toastMsg(config('custom.msg.create'),'success');

        return redirect()->route('admin.clients.index')->with($notification);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ClientRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $Client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        $statusOptions = StatusEnum::lists();
        return view('admin.pages.clients.edit',compact('client','statusOptions'));
    }
    
    public function update(ClientRequest $request, Client $client)
    {
        $data = $request->validated();
        if ($request->hasFile('icon')) {
            if ($client->icon) {
                Storage::delete($client->icon);
            }
            $data['icon'] = $request->file('icon')->store(Filepath::CLIENTS);
        }

        if ($request->hasFile('logo')) {
            if ($client->logo) {
                Storage::delete($client->logo);
            }
            $data['logo'] = $request->file('logo')->store(Filepath::CLIENTS);
        }
        $client->update($data);
        $notification = Str::toastMsg(config('custom.msg.update'),'success');
        return redirect()->route('admin.clients.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        try {
            // Delete the icon file if it exists
            if ($client->icon) {
                Storage::delete($client->icon);
            }

            // Delete the logo file if it exists
            if ($client->logo) {
                Storage::delete($client->logo);
            }
            
            // Delete the client record
            $client->delete();

            // Return JSON response for AJAX requests
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Client deleted successfully!'
                ]);
            }

            // Return redirect for regular requests
            $notification = Str::toastMsg(config('custom.msg.delete'),'success');
            return redirect()->route('admin.clients.index')->with($notification);
            
        } catch (\Exception $e) {
            // Return JSON response for AJAX requests
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete client: ' . $e->getMessage()
                ], 500);
            }

            // Return redirect for regular requests
            return redirect()->back()->with('error', 'Failed to delete client: ' . $e->getMessage());
        }
    }

}