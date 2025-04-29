<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Pivot entre Actor y Character,
 * con datos adicionales (mastery_level, notes).
 */
class ActorCharacter extends Model
{
    use HasFactory;

    // Laravel asume tabla `actor_characters`

    /** Campos asignables en masa. */
    protected $fillable = [
        'actor_id',
        'character_id',
        'mastery_level',
        'notes',
    ];

    /** Casteos para trabajar con datos nativos. */
    protected $casts = [
        'actor_id'      => 'integer',
        'character_id'  => 'integer',
        'mastery_level' => 'integer',
    ];

    /**
     * Relación inversa hacia Actor.
     */
    public function actor()
    {
        return $this->belongsTo(Actor::class);
    }

    /**
     * Relación inversa hacia Character.
     */
    public function character()
    {
        return $this->belongsTo(Character::class);
    }
}
