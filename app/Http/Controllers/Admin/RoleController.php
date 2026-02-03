<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:All Roles', ['only' => ['index']]);
        $this->middleware('permission:Add Role', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit Role', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Delete Role', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index(Request $request)
    {
        $roles = Role::orderBy('id', 'ASC')->paginate(COUNT);

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     *
     */
    public function create()
    {

        $admin = Auth::user();


        if ($admin->hasRole('Owner')) {
            $permission = Permission::all();
        } else {
            $permission = $admin->getAllPermissions();
        }

        return view('admin.roles.create', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|unique:roles,name',
                'permission' => 'required|array|exists:permissions,id',
            ],
            [
                'name.required' => __('ROLE_NAME') . ' ' . __('REQUIRED_FIELD'),
                'permission.required' => __('PERMISSIONS') . ' ' . __('REQUIRED_FIELD'),
            ]
        );

        $role = Role::create(['name' => $request->input('name')]);
        $permissions = Permission::whereIn('id', $request->input('permission'))->get()->pluck('name')->toArray();

        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')
            ->with('success', __('SUCCESS'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('admin.roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     */
    public function edit($id)
    {
        $admin = Auth::user();

        if ($admin->hasRole('Owner')) {
            $permission = Permission::all(); // Fetch all permissions
        } else {
            $permission = $admin->getAllPermissions(); // Fetch user's permissions
        }

        $role = Role::find($id);

        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('admin.roles.edit', compact('role', 'permission', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     */
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|unique:roles,name,' . $id,
                'permission' => 'required|array|exists:permissions,id',
            ],
            [
                'name.required' => __('ROLE_NAME') . ' ' . __('REQUIRED_FIELD'),
                'name.unique' => __('ROLES') . ' ' . __('ALREADY_EXISTS'),
                'permission.required' => __('PERMISSIONS') . ' ' . __('REQUIRED_FIELD'),
            ]
        );

        $role = Role::find($id);

        if (!$role) {
            return redirect()->route('roles.index')
                ->with('error', __('NOT_FOUND'));
        }

        $role->name = $request->input('name');
        $role->save();
        $permissions = Permission::whereIn('id', $request->input('permission'))->get()->pluck('name')->toArray();

        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')
            ->with('success', __('SUCCESS'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     */
    // public function destroy($id)
    // {
    //     DB::table("roles")->where('id', $id)->delete();
    //     return redirect()->route('roles.index')
    //         ->with('Add', 'Role deleted Addfully');
    // }

    public function destroy($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return redirect()->back()->with('error', __('NOT_FOUND'));
        }

        $admin = DB::table("model_has_roles")->where('role_id', $id)->first();

        if ($admin) {
            return redirect()->back()->with('warning', __('ROLE_IN_USE'));
        }

        $role->delete();
        return redirect()->route('roles.index')->with('success', __('SUCCESS'));
    }
}
