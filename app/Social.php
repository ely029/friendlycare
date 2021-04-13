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
 * @method static \Illuminate\Database\Eloquent\Builder|Social newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Social newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Social query()
 * @method static \Illuminate\Database\Eloquent\Builder|Social whereDriver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Social whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Social whereSocialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Social whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Social whereUserId($value)
 * @mixin \Eloquent
 */
class Social extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
