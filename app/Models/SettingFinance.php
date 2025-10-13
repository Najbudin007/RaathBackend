<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingFinance extends Model
{
    use HasFactory;

    protected $fillable = ['tax','deduction_charge'];
}
