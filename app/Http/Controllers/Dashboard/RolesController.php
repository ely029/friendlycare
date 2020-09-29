<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Role;
use App\RoleAccess;
use App\RoleRoute;

class RolesController extends Controller
{
    public function index()
    {
        return view('dashboard.roles.index', [
            'roles' => Role::query()->orderBy('created_at', 'desc')->paginate(),
        ]);
    }

    public function create()
    {
        return view('dashboard.roles.form')->with([
            'method' => 'POST',
        ]);
    }

    public function store()
    {
        $this->validate(request(), [
            'name' => 'required',
            'role_access.*' => 'in:' . RoleRoute::getActionName()->implode(','),
        ]);

        $role = Role::forceCreate([
            'name' => request('name'),
        ]);

        $accesses = request('role_access');

        if ($accesses !== null) {
            foreach ($accesses as $route) {
                RoleAccess::forceCreate([
                    'role_id' => $role->id,
                    'route' => $route,
                ]);
            }
        }

        return redirect('dashboard/roles')->with([
            'alert.context' => $context = 'success',
            'alert.title' => trans("boilerplate.alert.{$context}.title"),
            'alert.message' => trans("boilerplate.alert.{$context}.message", [
                'action' => trans('boilerplate.actions.created'),
                'object' => trans('boilerplate.objects.role'),
            ]),
        ]);
    }

    public function edit(Role $role)
    {
        return view('dashboard.roles.form', compact('role'))->with([
            'method' => 'PATCH',
        ]);
    }

    public function update(Role $role)
    {
        $this->validate(request(), [
            'name' => 'required',
            'role_access.*' => 'in:' . RoleRoute::getActionName()->implode(','),
        ]);

        $role->name = request('name');
        $role->save();

        $role->accesses()->delete();

        $accesses = request('role_access');

        if ($accesses !== null) {
            $routes = [];

            foreach ($accesses as $route) {
                $routes[] = new RoleAccess(['route' => $route]);
            }

            $role->accesses()->saveMany($routes);
        }

        return redirect("dashboard/roles/{$role->id}/edit")->with([
            'alert.context' => $context = 'success',
            'alert.title' => trans("boilerplate.alert.{$context}.title"),
            'alert.message' => trans("boilerplate.alert.{$context}.message", [
                'action' => trans('boilerplate.actions.edited'),
                'object' => trans('boilerplate.objects.role'),
            ]),
        ]);
    }

    public function destroy(Role $role)
    {
        if (! $role->is_deletable) {
            abort(403);
        }
        $role->delete();

        return redirect('dashboard/users')->with([
            'alert.context' => $context = 'warning',
            'alert.title' => trans("boilerplate.alert.{$context}.title"),
            'alert.message' => trans("boilerplate.alert.{$context}.message", [
                'action' => trans('boilerplate.actions.deleted'),
                'object' => trans('boilerplate.objects.role'),
            ]),
        ]);
    }
}
