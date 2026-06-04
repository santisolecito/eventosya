<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'price',
        'total_qty',
        'sold_qty',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function available(): int
    {
        return $this->total_qty - $this->sold_qty;
    }

    public function hasStock(): bool
    {
        return $this->available() > 0;
    }
}
