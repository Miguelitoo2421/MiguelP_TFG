<?php

// app/Models/Event.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'play_id',
        'location_id',
        'title',
        'scheduled_at',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function play()
    {
        return $this->belongsTo(Play::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function actorCharacters()
    {
        return $this->hasMany(\App\Models\ActorCharacter::class);
    }
}
