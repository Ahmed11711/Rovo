<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Helper\Files;
use App\Traits\HasBranch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Http;

class User extends Authenticatable
{

    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use HasBranch;

    protected function getDefaultGuardName(): string
    {
        return 'web';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'branch_id',
        'restaurant_id',
        'locale'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
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
        ];
    }

    protected function defaultProfilePhotoUrl()
    {
        $name = trim(collect(explode(' ', $this->name))->map(function ($segment) {
            return mb_substr($segment, 0, 1);
        })->join(' '));

        return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&color=#27272a&background=f4f4f5';
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function isRestaurantActive(): bool
    {
        return $this->restaurant?->is_active ?? true;
    }

    public function isRestaurantApproved(): bool
    {
        return $this->restaurant?->approval_status === 'Approved';
    }

    public function updateProfilePhoto($photo)
    {
        $path = 'profile-photos';

        // If there is an old profile photo, delete it
        if ($this->profile_photo_path) {
            $oldPhotoPath = public_path($this->profile_photo_path);
            if (file_exists($oldPhotoPath)) {
                unlink($oldPhotoPath);
            }
        }

        $filename = Files::uploadLocalOrS3($photo, $path, width: 150, height: 150);
        // Update the user's profile photo path in the database
        $this->forceFill([
            'profile_photo_path' => $path . '/' . $filename,
        ])->save();
    }

    public static function validateLoginActiveDisabled($user)
    {

        self::restrictUserLoginFromOtherSubdomain($user);

        // Check if restaurant is active
        if (!$user->isRestaurantActive()) {
            throw ValidationException::withMessages([
                'email' => __('Restaurant is inactive. Contact admin.')
            ]);
        }
    }

    private static function restrictUserLoginFromOtherSubdomain($user)
    {
        if (!module_enabled('Subdomain')) {
            return true;
        }

        $restaurant = getRestaurantBySubDomain();

        // Check if superadmin is trying to login. Make sure the database do not have main domain as subdomain
        if (!$restaurant) {
            $userCount = User::whereNull('restaurant_id')->count();
            return $userCount > 0;
        };


        // Check if user is trying to login from other restaurant
        if ($user->restaurant_id !== $restaurant->id) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed')
            ]);
        }

        return true;
    }

    public function getTimezoneFromIp(): string
    {
        $ip = request()->ip();

        try {
            $response = Http::get('http://ip-api.com/json/' . $ip);

            if ($response->failed()) {
                return 'UTC';
            }

            if ($response->json()['status'] == 'success') {
                return $response->json()['timezone'] ?? 'UTC';
            }

            return 'UTC';
        } catch (\Throwable $th) {
            return 'UTC';
        }
    }

    public function getCountryFromIp(): string
    {
        $ip = request()->ip();
        $ipCountry = 'US';

        try {
            $response = Http::get('http://ip-api.com/json/' . $ip);

            if ($response->failed()) {
                $ipCountry = 'US';
            } else {
                if ($response->json()['status'] == 'success') {
                    $ipCountry = $response->json()['countryCode'];
                }
            }
        } catch (\Throwable $th) {
            $ipCountry = 'US';
        }

        return $ipCountry;
    }
}
