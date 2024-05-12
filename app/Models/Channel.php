<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Channel extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::creating(function (Channel $channel) {
            $channel->key = static::generateKey();
        });
    }

    public static function generateKey(): string
    {
        $key = Str::random(32);
        if (Channel::where('key', $key)->exists()) {
            return static::generateKey();
        }
        return $key;
    }

    protected $fillable = ['key'];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function subscribers()
    {
        return $this->belongsToMany(User::class, 'channel_subscribers');
    }
}
