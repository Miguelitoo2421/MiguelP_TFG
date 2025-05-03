<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Play, ActorCharacter, Actor};

class Character extends Model
{
    use HasFactory;

    /**
     * Campos asignables en masa.
     */
    protected $fillable = [
        'name',
        'notes',
        'image', // ruta o URL de la imagen
    ];

    /**
     * Relación muchos a muchos con actores a través de actor_characters.
     */
    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'actor_characters')
                    ->withPivot('mastery_level', 'notes')
                    ->withTimestamps();
    }

    /**
     * Relación uno a muchos con actor_characters (pivot explícito).
     */
    public function actorCharacters()
    {
        return $this->hasMany(ActorCharacter::class);
    }

    /**
     * Relación muchos a muchos con obras (plays) a través de character_play.
     */
    public function plays()
    {
        return $this->belongsToMany(Play::class, 'character_play')->withTimestamps();
    }

    public function getImageUrlAttribute()
{
    return $this->image
        ? asset('storage/' . $this->image)
        : asset('storage/characters/image_user.png');
}

}
