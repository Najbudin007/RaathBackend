<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\SettingEmail;
use App\Models\SettingSocial;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = Setting::create([
            'name' => 'Game',
            'email' => 'noreply@game.com',
            'address' => 'Nepal',
            'phone' => '977 01-4000000',
            'description_limit' => 20,
            'item_perpage' => 20,
            'thumb_width' => 100,
            'thumb_height' => 100,
            'image_width' => 200,
            'image_height' => 200,
            'meta_title' => 'Game',
            'meta_keyword' => 'Game',
            'meta_description' => 'Game',
        ]);
        SettingEmail::create([
            'setting_id' => $setting->id,
            'protocol' => 'SMTP',
            'parameter' => 'noreply@game.com',
            'host_name' => 'smtp.mailtrap.io',
            'smtp_port' => 2525,
            'username' => '',
            'password' => '',
            'encryption' => 'tls'
        ]);
        SettingSocial::create([
            'setting_id' => $setting->id,
            'title' => 'facebook',
            'icon' => 'fab fa-facebook-square',
            'url' => 'facebook.com',
        ]);
    }
}
