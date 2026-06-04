<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'organizer_id',
        'category_id',
        'title',
        'slug',
        'description',
        'venue',
        'city',
        'event_date',
        'event_time',
        'cover_image',
        'active',
    ];

    protected $casts = [
        'event_date' => 'date',
        'active'     => 'boolean',
    ];

    public function setTitleAttribute($value): void
    {
        $this->attributes['title'] = $value;
        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = Str::slug($value) . '-' . Str::random(5);
        }
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function availableSpots(): int
    {
        return $this->tickets->sum(fn($t) => $t->total_qty - $t->sold_qty);
    }
}
