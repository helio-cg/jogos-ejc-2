<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class Admin extends Authenticatable implements FilamentUser
{
    use HasFactory;
    
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'email_verified_at' => 'datetime',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function setPasswordAttribute($value)
    {
        if ($value && !Hash::needsRehash($value)) {
            $this->attributes['password'] = $value; // Já é um hash
        } else {
            $this->attributes['password'] = bcrypt($value); // Criptografa se for texto puro
        }
       // $this->attributes['password'] = bcrypt($value);
    }
}
