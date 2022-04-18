<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'nome'
    ];

    protected $perPage = 3;
    protected $appends = ['links'];

    public function episodios()
    {
        return $this->belongsToMany(Episodio::class);
    }

    public function getLinksAttribute(): array
    {
        return [
            'self' => "api/serie/{$this->id}",
            'episodios' => "api/serie/{$this->id}/episodios"
        ];
    }
}
