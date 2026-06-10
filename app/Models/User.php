<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use App\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, LogsActivity, HasRoles, HasPanelShield;

    /**
     * The guard name for Spatie Permission.
     *
     * @var string
     */
    public $guard_name = 'web';

    public function canAccessPanel(Panel $panel): bool
    {
        return in_array($this->role, ['admin', 'superadmin']);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'satuan_kerja',
        'is_validated',
        'unique_slug',
        'no_hp',
        'surat_tugas',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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
            'is_validated' => 'boolean',
            'last_seen_at' => 'datetime',
        ];
    }

    /**
     * Sync Spatie roles when the 'role' column changes.
     */
    protected static function booted(): void
    {
        static::creating(function (User $user) {
            if (empty($user->unique_slug)) {
                $user->unique_slug = Str::random(10);
            }
        });

        static::saved(function (User $user) {
            if ($user->wasChanged('role')) {
                // Remove all existing Spatie roles
                $user->syncRoles([]);

                // Assign the matching Spatie role
                match ($user->role) {
                    'superadmin' => $user->assignRole('super_admin'),
                    'admin' => $user->assignRole('panel_user'),
                    default => null, // 'user' gets no Spatie role
                };
            }
        });
    }
    
    // Role checking methods
    public function isUser()
    {
        return $this->role === 'user';
    }
    
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    
    public function isSuperadmin()
    {
        return $this->role === 'superadmin';
    }
    
    public function hasAdminAccess()
    {
        return in_array($this->role, ['admin', 'superadmin']);
    }

    /**
     * Check if user is currently online (active in last 5 minutes).
     */
    public function isOnline(): bool
    {
        return $this->last_seen_at && $this->last_seen_at->diffInMinutes(now()) < 5;
    }
    
    // Relationships
    public function isbnSubmissions()
    {
        return $this->hasMany(IsbnSubmission::class);
    }
    
    public function reviewedSubmissions()
    {
        return $this->hasMany(IsbnSubmission::class, 'reviewed_by');
    }
}
