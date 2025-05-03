<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class Producer extends Model
{
    use HasFactory;

    /**
     * Campos asignables en masa.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'name',
        'cif',
        'image',   // ruta o URL de la imagen
    ];

    /**
     * Una productora puede tener muchas obras (plays).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function plays(): HasMany
    {
        return $this->hasMany(Play::class);
    }

    public function getProfileImageUrlAttribute(): string
    {
        return $this->image
            ? Storage::url($this->image)
            : asset('storage/producers/image_user.png');
    }

}
