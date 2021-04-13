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
 * @method static \Illuminate\Database\Eloquent\Builder|RoleAccess newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleAccess newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleAccess query()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleAccess whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleAccess whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleAccess whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleAccess whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleAccess whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RoleAccess extends Model
{
    protected $fillable = [
        'role_id',
        'route',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
