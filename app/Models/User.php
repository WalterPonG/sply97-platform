<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'xp', 'points', 'avatar', 'bio', 'clash_tag'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
	    'last_login_xp_at' => 'datetime',
	    'last_login_date' => 'datetime',
        ];
    }

	// nivel usuario
    public function level(){
	return (int) floor(($this->xp ?? 0) /100);
    }
	// util para subir de nivel limpio
    public function xpForNextLevel()
    {
	return ($this->level() + 1) * 100;
    }


     public function canReceiveDailyLoginXp(): bool
{
    return !$this->last_login_xp_at ||
        $this->last_login_xp_at->diffInHours(now()) >= 24;
}

public function markLoginXp(): void
{
    $this->last_login_xp_at = now();
    $this->save();
}
}
