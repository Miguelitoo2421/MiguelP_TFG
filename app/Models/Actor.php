<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use App\Models\ActorCharacter;
use App\Models\Character;

class Actor extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Campos asignables en masa.
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'city',
        'has_car',
        'can_drive',
        'active',
        'image',   
        'notes',
        'role',
    ];

    
    //Casteos de atributos para que Eloquent convierta automáticamente a booleano. 
    protected $casts = [
        'has_car'   => 'boolean',
        'can_drive' => 'boolean',
        'active'    => 'boolean',
    ];

    //Relación uno a muchos con actor_characters (pivot).
    public function actorCharacters()
    {
        return $this->hasMany(ActorCharacter::class);
    }

    
    //Relación muchos a muchos con Character a través de actor_characters.
    public function characters()
    {
        return $this->belongsToMany(Character::class, 'actor_characters')
                    ->withPivot('mastery_level', 'notes')
                    ->withTimestamps();
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? Storage::url($this->image)
            : asset('storage/actors/image_user.png');
    }

}
