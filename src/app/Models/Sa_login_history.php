<?php

namespace ikepu_tp\SecureAuth\app\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $loginId
 * @property string $user_id
 * @property string $guard
 * @property string $ip_address
 * @property string $user_agent
 * @property string $device
 * @property string $browser
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Sa_login_history extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'loginId' => 'string',
        'user_id' => 'string',
        'ip_address' => 'string',
        'user_agent' => 'string',
        'device' => 'string',
        'browser' => 'string',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ["id", "created_at", "updated_at", "deleted_at"];
}