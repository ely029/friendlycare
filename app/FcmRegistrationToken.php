<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\FcmRegistrationToken
 *
 * @property int $id
 * @property int $user_id
 * @property string $registration_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FcmRegistrationToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FcmRegistrationToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FcmRegistrationToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FcmRegistrationToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FcmRegistrationToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FcmRegistrationToken whereRegistrationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FcmRegistrationToken whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FcmRegistrationToken whereUserId($value)
 * @mixin \Eloquent
 */
// @TB: See FcmClient
class FcmRegistrationToken extends Model
{
}
