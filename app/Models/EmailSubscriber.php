<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailSubscriber extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['email', 'verification_token'];

    public static function generateVerificationToken()
    {
        return hash_hmac('sha256', Str::random(40), config('app.key'));
    }
}