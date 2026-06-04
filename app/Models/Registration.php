<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'user_id',
        'code',
        'status',
        'registered_at',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function ($registration) {
            $registration->code = strtoupper(Str::random(10));
        });
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->ticket->event;
    }
}
