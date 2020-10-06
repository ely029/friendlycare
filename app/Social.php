<?php

 declare(strict_types=1);

 namespace App;

 use Illuminate\Database\Eloquent\Model;

/**
 * App\Social
 *
 * @property int $id
 * @property int $user_id
 * @property string $driver
 * @property string $social_id
 * @property string $token
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Social newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Social newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Social query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Social whereDriver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Social whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Social whereSocialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Social whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Social whereUserId($value)
 * @mixin \Eloquent
 */
class Social extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
