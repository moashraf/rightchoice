<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use App\Enums\RoleEnum;
use App\Enums\UserTypeEnum;
use App\Enums\UserStatusEnum;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
         'MOP',
         'status',
         'AGE',
         'TYPE',
         'Job_title',
        'Tax_card',
         'Commercial_Register',
         'Employee_Name',
         'profile_image',
         'phone_verfied_sms_status',
         'phone_sms_otp',
         'isAdmin',
         'invited_by',
         'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];





    public function prices()
    {
        return $this->belongsToMany(Pricing::Class, 'users_priceing_sale',
          'user_id', 'pricing_id');
    }

    public function wishlist()
    {
        return $this->hasMany(wish::class,'user_id','id');
    }
    public function companiess()
    {
        return $this->hasMany(Company::class,'user_id','id');
    }
     public function contact()
    {
        return $this->hasMany(UserContactAqar::class,'user_id','id');
    }

    public function userpricing()
    {
        return $this->hasMany(UserPriceing::class);
    }

    public function userpricin()
    {
        return $this->belongsTo(UserPriceing::class,'id','user_id')->orderBy('id','desc');
    }

    public function notification()
    {
        return $this->hasMany(Notification::class,'user_id','id');
    }

    public function UserPriceing()
    {
        return $this->belongsToMany(priceing_sale::class, 'users_priceing_sale', 'user_id', 'pricing_id');
    }

    public function getUserType()
    {
        if($this->TYPE == 1)
            return UserTypeEnum::Buyer;
        if($this->TYPE == 2)
            return UserTypeEnum::SALER;
        if($this->TYPE == 3)
            return UserTypeEnum::DEVELOPER;
        if($this->TYPE == 4)
            return UserTypeEnum::COMPANY;
        return '';
    }

    public function getStatus()
    {
        if($this->status == 1) {
            return UserStatusEnum::ACTIVE;
        } elseif($this->status == 0) {
            return UserStatusEnum::UNACTIVE;
        } else {
            return UserStatusEnum::BLOCK;
        }
    }

    public function aqars()
    {
        return $this->hasMany(aqar::class, 'user_id');
    }

    // ─────────────────────────────────────────────────────────
    // RBAC Relationship & Helpers
    // ─────────────────────────────────────────────────────────

    /**
     * The role assigned to this user.
     */
    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Role::class, 'role_id');
    }

    /**
     * Check if the user has the given role name.
     *
     * Usage: $user->hasRole('admin')
     *        $user->hasRole(RoleEnum::ADMIN)
     */
    public function hasRole(string $role): bool
    {
        return $this->role && $this->role->name === $role;
    }

    /**
     * Check if the user has a specific permission through their role.
     * Loads role.permissions once and caches it for the lifetime of the request.
     *
     * Usage: $user->hasPermission('users.delete')
     */
    public function hasPermission(string $permission): bool
    {
        if (! $this->role_id) {
            return false;
        }

        // Load role with permissions if not already eager-loaded
        if (! $this->relationLoaded('role')) {
            $this->load('role.permissions');
        } elseif ($this->role && ! $this->role->relationLoaded('permissions')) {
            $this->role->load('permissions');
        }

        return $this->role && $this->role->permissions->contains('name', $permission);
    }

    /**
     * True if this user is a read-only viewer (cannot create/update/delete).
     *
     * Usage in Blade: @if(auth()->user()->canViewOnly())
     */
    public function canViewOnly(): bool
    {
        return $this->hasRole(RoleEnum::VIEWER);
    }

    /**
     * True if the user has the admin role.
     * Replaces direct checks on the legacy isAdmin column in new code.
     *
     * Usage: $user->isAdminRole()
     */
    public function isAdminRole(): bool
    {
        return $this->hasRole(RoleEnum::ADMIN);
    }

    /**
     * Get profile image URL.
     */
    public function getProfileImageUrlAttribute(): string
    {
        if ($this->profile_image) {
            return url('/images/' . $this->profile_image);
        }
        return url('/images/default-avatar.png');
    }

    /**
     * Check if the user was active recently (within last 5 minutes).
     */
    public function isOnline(): bool
    {
        if (!$this->last_seen_at) {
            return false;
        }
        return \Carbon\Carbon::parse($this->last_seen_at)->diffInMinutes(now()) <= 5;
    }

}
