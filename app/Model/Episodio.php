<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Episodio extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'temporada',
        'numero',
        'assistido',
        'serie_id'
    ];
    protected $appends = ['links'];

    public function series()
    {
        return $this->hasMany(Serie::class);
    }

    public function getAssistidoAttribute($assistido): bool
    {
        return $assistido;
    }

    public function getLinksAttribute(): array
    {
        return [
            'self' => "api/episodio/{$this->id}",
            'serie' => "api/serie/{$this->serie_id}"
        ];
    }

}
