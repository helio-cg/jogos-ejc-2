<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

#[Fillable(['name', 'email', 'whatsapp', 'password', 'active', 'status', 'paroquia_id', 'role', 'parent_id', 'team_name', 'team_number'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (User $user) {
            if ($user->role === 'sub_user' && $user->parent_id && !$user->team_name) {
                $nextNumber = User::where('parent_id', $user->parent_id)
                    ->where('role', 'sub_user')
                    ->max('team_number');

                $user->team_number = ($nextNumber ?? 0) + 1;
                $user->team_name = 'Time ' . $user->team_number;
            }
        });
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'active' => 'boolean',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function atleta(): HasMany
    {
        return $this->hasMany(Atleta::class);
    }

    public function paroquia(): BelongsTo
    {
        return $this->belongsTo(Paroquia::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    public function userModalidades(): HasMany
    {
        return $this->hasMany(UserModalidade::class);
    }

    public function isParent(): bool
    {
        return $this->role === 'parent';
    }

    public function isSubUser(): bool
    {
        return $this->role === 'sub_user';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completo';
    }

    public function getChildUserIds(): array
    {
        return $this->children()->pluck('id')->toArray();
    }

    public function getAllVisibleUserIds(): array
    {
        $ids = [$this->id];
        if ($this->isParent()) {
            array_push($ids, ...$this->getChildUserIds());
        }
        return $ids;
    }

    public function getParishUserIds(): array
    {
        return User::where('paroquia_id', $this->paroquia_id)
            ->where('active', true)
            ->pluck('id')
            ->toArray();
    }

    public function setPasswordAttribute($value)
    {
        if ($value && !Hash::needsRehash($value)) {
            $this->attributes['password'] = $value;
        } else {
            $this->attributes['password'] = bcrypt($value);
        }
    }
}
