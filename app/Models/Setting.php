<?php

namespace App\Models;

use App\Library\ImageTool;
use App\Models\SettingEmail;
use App\Models\SettingSocial;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'address', 'phone', 'google_analytics', 'latitude', 'longitude', 'description_limit', 'item_perpage', 'logo', 'favicon', 'thumb_height', 'thumb_width', 'image_height', 'image_width', 'meta_title', 'meta_keyword', 'meta_description'];

    public function emails()
    {
        return $this->hasOne(SettingEmail::class, 'setting_id');
    }
    public function socials()
    {
        return $this->hasMany(SettingSocial::class, 'setting_id');
    }

    public function getIconPathAttribute()
    {
        $path = 'default_image/no-image.png';
        if(!empty($this->icon))
        {
            if (Storage::exists($this->icon))
            {
                $path = $this->icon;
            }
        }
        return ImageTool::mycrop($path, 100, 100);
    }
    public function getLogoPathAttribute()
    {
        $path = 'default_image/no-image.png';
        if(!empty($this->logo))
        {
            if (Storage::exists($this->logo))
            {
                $path = $this->logo;
            }
        }
        return ImageTool::mycrop($path, 100, 100);
    }
}
