<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\RoleAccess
 *
 * @property int $id
 * @property int $role_id
 * @property string $route
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Role $role
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RoleAccess newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RoleAccess newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RoleAccess query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RoleAccess whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RoleAccess whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RoleAccess whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RoleAccess whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RoleAccess whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RoleAccess extends Model
{
    protected $fillable = ['role_id', 'route'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
