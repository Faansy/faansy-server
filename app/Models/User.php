<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, HasUlids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'user_image_url',
        'user_background_image_url',
        'show_activity_status',
        'free_subscription',
        'subscription_amount',
        'show_subscription_offers',
        'passport_image_url',
        'verified',
    ];

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

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /** 
     * Model Relationships
     */

    public function blocks(): HasMany
    {
        return $this->hasMany(Block::class);
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }

    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class);
    }

    public function livestreams(): HasMany
    {
        return $this->hasMany(Livestream::class);
    }

    public function livestreamcomments(): HasMany
    {
        return $this->hasMany(Livestreamcomment::class);
    }

    public function livestreamguests(): HasMany
    {
        return $this->hasMany(Livestreamguest::class);
    }

    public function livestreamlikes(): HasMany
    {
        return $this->hasMany(Livestreamlike::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function polls(): HasMany
    {
        return $this->hasMany(Poll::class);
    }

    public function postcomments(): HasMany
    {
        return $this->hasMany(Postcomment::class);
    }

    public function postlikes(): HasMany
    {
        return $this->hasMany(Postlike::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function restricts(): HasMany
    {
        return $this->hasMany(Restrict::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function subscribers(): HasMany
    {
        return $this->hasMany(Subscription::class, 'subscriber_id');
    }

    public function subscribed(): HasMany
    {
        return $this->hasMany(Subscription::class, 'subscribed_id');
    }

    public function tips(): HasMany
    {
        return $this->hasMany(Tip::class);
    }

    public function userlikers(): HasMany
    {
        return $this->hasMany(Userlike::class, 'liker_id');
    }

    public function userliked(): HasMany
    {
        return $this->hasMany(Userlike::class, 'liked_id');
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    public function walletfundings(): HasMany
    {
        return $this->hasMany(Wallet::class);
    }

    // Atrributes Casts
    public function subscription_amount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100
        );
    }
}
