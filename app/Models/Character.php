<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Play;
use App\Models\ActorCharacter;
use App\Models\Actor;

class Character extends Model
{
    use HasFactory;

    /**
     * Campos asignables en masa.
     *
     * @var array<string>
     */
    protected $fillable = [
        'play_id',
        'name',
        'notes',
        'image',       // ruta o URL de la imagen
    ];

    /**
     * Casteo de tipos de atributos.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'play_id' => 'integer',
    ];

    /**
     * Un personaje pertenece a una sola obra (Play).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function play()
    {
        return $this->belongsTo(Play::class);
    }

    /**
     * Relación uno a muchos con pivot actor_characters.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actorCharacters()
    {
        return $this->hasMany(ActorCharacter::class);
    }

    /**
     * Relación muchos a muchos con Actor a través de actor_characters.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'actor_characters')
                    ->withPivot('mastery_level', 'notes')
                    ->withTimestamps();
    }
}
