<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserModalidade extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'modalidade',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
