<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Support\Facades\Storage;


use Spatie\Permission\Traits\HasRoles;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;

use TomatoPHP\FilamentDiscord\Traits\InteractsWithDiscord;

class User extends Authenticatable implements HasAvatar, FilamentUser
{
    use HasApiTokens;
    use HasRoles;
    use HasPanelShield;
    use HasFactory;
    use Notifiable;
    use InteractsWithDiscord;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $guarded = [
        'id',
    ];
    // protected $fillable = [
    //     'name',
    //     'no_hp',
    //     'alamat',
    //     'email',
    //     'password',
    //     'role',
    //     'cabangs_id',
    //     'bisnis_id',
    // ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }


    // public function addres() : Morphone 
    // {
    //     return $this->morphone(related:addres::class,name:'addresable');
    // }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ? Storage::url("$this->avatar_url") : null;
    }

    public function bisnis()
    {
        return $this->belongsTo(Bisnis::class);
    }
    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabangs_id');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->email && $this->password;
    }
    
}
