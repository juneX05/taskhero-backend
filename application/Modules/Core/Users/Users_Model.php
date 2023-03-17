<?php

namespace Application\Modules\Core\Users;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Application\Modules\Core\Users\Users_Model
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_status_id
 * @property int $user_id
 * @property int $user_type_id
 * @property string $urid
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|Users_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Users_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Users_Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|Users_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users_Model whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users_Model whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users_Model whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users_Model wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users_Model whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users_Model whereUrid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users_Model whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users_Model whereUserStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users_Model whereUserTypeId($value)
 * @mixin \Eloquent
 */
class Users_Model extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'urid',
        'user_status_id',
        'user_id',
        'user_type_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
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
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->urid = sha1(hrtime(true));
        });
    }
}
