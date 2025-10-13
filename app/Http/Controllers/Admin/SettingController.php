<?php

namespace App\Http\Controllers\Admin;

use App\Filepath;
use App\Models\Setting;
use Illuminate\Support\Str;
use App\Models\SettingEmail;
use App\Models\SettingSocial;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\SettingRequest;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::with(['emails', 'socials'])->latest('id')->first();
        $datas['proto'][] = array('title' => 'SMTP', 'value' => 'smtp');
        $datas['proto'][] = array('title' => 'Localhost', 'value' => 'sendmail');
        $datas['proto'][] = array('title' => 'Mailgun', 'value' => 'mailgun');
        $datas['proto'][] = array('title' => 'mandrill', 'value' => 'mandrill');
        return view('admin.pages.settings.index', compact('setting', 'datas'));
    }

    public function update(SettingRequest $request, Setting $setting)
    {
   
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            if ($setting->logo) {
                Storage::delete($setting->logo);
            }
            $data['logo'] = $request->file('logo')->store(Filepath::SETTING);
        }  
         
        if ($request->hasFile('favicon')) {
            if ($setting->favicon) {
                Storage::delete($setting->favicon);
            }
            $data['favicon'] = $request->file('favicon')->store(Filepath::SETTING);
        }     

        $setting->update($data);

        SettingEmail::where('setting_id', $setting->id)->update([
            'protocol' => $request->protocol,
            'parameter' => $request->parameter,
            'host_name' => $request->host_name,
            'username' => $request->username,
            'password' => $request->password,
            'smtp_port' => $request->smtp_port,
            'encryption' => $request->encryption,
        ]);

        $countSocial = isset($request->social) ? count($request->social['title']) : 0;
        if ($countSocial > 0) {
            SettingSocial::where('setting_id', $setting->id)->delete();
            for ($i = 0; $i < $countSocial; $i++) {
                $socialdata[] = [
                    'setting_id' => $setting->id,
                    'title' => $request->social['title'][$i],
                    'icon' => $request->social['icon'][$i],
                    'url' => $request->social['url'][$i],
                ];
            }
            SettingSocial::insert($socialdata);
        }

        $notification = Str::toastMsg(config('custom.msg.create'), 'success');
        return back()->with($notification);
    }
}
