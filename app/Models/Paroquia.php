<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paroquia extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'city',
    ];

    public function atletas()
    {
        return $this->hasMany(Atleta::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
