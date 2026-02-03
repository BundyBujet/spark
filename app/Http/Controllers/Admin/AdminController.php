<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminStoreRequest;
use App\Http\Requests\AdminUpdateRequest;

class AdminController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:All Admins', ['only' => ['index']]);
        $this->middleware('permission:Add Admin', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit Admin', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Delete Admin', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::orderBy('id', 'ASC')->paginate(COUNT);
        return view("admin.admins.index", compact("admins"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view("admin.admins.create", compact("roles"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminStoreRequest $request)
    {

        $admin = Admin::create([
            "name" => $request->name,
            "username" => $request->username,
            "password" => bcrypt($request->password),
            'status' => $request->status,
            'added_by' => auth()->user()->id,
        ]);
        $roles = Role::whereIn('name', $request->input('roles'))->get()->pluck('name')->toArray();

        $admin->syncRoles($roles);
        return redirect()->route("admins.index")->with("success", __('message.SuccessAddAdmin'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $admin = Admin::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $adminRole = $admin->roles->pluck('name', 'name')->all();
        return view("admin.admins.edit", compact("admin", "roles", "adminRole"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminUpdateRequest $request, string $id)
    {

        $exists = Admin::where("username", $request->username)->where("id", '!=', $id)->first();
        if ($exists) {
            return redirect()->back()->with('warning', __('message.FoundAdmin'))->withInput();
        }

        $admin = Admin::findOrFail($id);
        $admin->update([
            "name" => $request->name,
            "username" => $request->username,
            "password" => bcrypt($request->password),
            'status' => $request->status,
            'updated_by' => auth()->user()->id,
        ]);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $roles = Role::whereIn('name', $request->input('roles'))->get()->pluck('name')->toArray();

        $admin->syncRoles($roles);
        return redirect()->route("admins.index")->with("success", __('meaasge.SuccessEdit'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = Admin::findOrFail($id);
        if (!$admin) {
            return redirect()->back()->with('warning', __('message.AdminNotFound'));
        }
        if ($admin->image) {
            $imagePath = public_path('assets/admins/images/' . $admin->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $admin->delete();
        return redirect()->route('admins.index')->with(['success' => __('message.SuccessDelete')]);
    }
    public function ajax_search(Request $request)
    {
        if ($request->ajax()) {
            $admins = Admin::where('name', 'LIKE', '%' . $request->search_by_text . '%')->orderBy("id", "ASC")->paginate(COUNT);
            return view("admin.admins.ajax_search", ["admins" => $admins]);
        }
    }
}
