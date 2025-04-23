<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Producer;
use App\Models\Character;

class Play extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Campos asignables en masa.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'name',
        'producer_id',
        'active',
        'notes',
        'image', // ruta/URL si guardas imagen
    ];

    /**
     * Una obra pertenece a una productora.
     */
    public function producer()
    {
        return $this->belongsTo(Producer::class);
    }

    /**
     * Muchos personajes pueden pertenecer a una obra,
     * usando la tabla pivote 'character_play'.
     */
    public function characters()
    {
        return $this->belongsToMany(Character::class, 'character_play')
                    ->withTimestamps();
    }
}
