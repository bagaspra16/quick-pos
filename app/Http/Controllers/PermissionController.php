<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::with('parent')->paginate(10);
        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        $parentPermissions = Permission::where('is_menu', true)->get();
        return view('permissions.create', compact('parentPermissions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:permissions',
            'description' => 'nullable|string',
            'menu_group' => 'nullable|string|max:255',
            'menu_icon' => 'nullable|string|max:255',
            'menu_order' => 'nullable|integer',
            'is_menu' => 'boolean',
            'parent_id' => 'nullable|exists:permissions,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Permission::create([
            'name' => $request->name,
            'slug' => $request->slug ?: Str::slug($request->name),
            'description' => $request->description,
            'menu_group' => $request->menu_group,
            'menu_icon' => $request->menu_icon,
            'menu_order' => $request->menu_order ?: 0,
            'is_menu' => $request->has('is_menu'),
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('permissions.index')
            ->with('success', 'Permission berhasil dibuat!');
    }

    public function show(Permission $permission)
    {
        $permission->load('parent', 'children', 'roles');
        return view('permissions.show', compact('permission'));
    }

    public function edit(Permission $permission)
    {
        $parentPermissions = Permission::where('is_menu', true)
            ->where('id', '!=', $permission->id)
            ->get();
            
        return view('permissions.edit', compact('permission', 'parentPermissions'));
    }

    public function update(Request $request, Permission $permission)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:permissions,slug,' . $permission->id,
            'description' => 'nullable|string',
            'menu_group' => 'nullable|string|max:255',
            'menu_icon' => 'nullable|string|max:255',
            'menu_order' => 'nullable|integer',
            'is_menu' => 'boolean',
            'parent_id' => 'nullable|exists:permissions,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $permission->name = $request->name;
        $permission->slug = $request->slug ?: Str::slug($request->name);
        $permission->description = $request->description;
        $permission->menu_group = $request->menu_group;
        $permission->menu_icon = $request->menu_icon;
        $permission->menu_order = $request->menu_order ?: 0;
        $permission->is_menu = $request->has('is_menu');
        $permission->parent_id = $request->parent_id;
        $permission->save();

        return redirect()->route('permissions.index')
            ->with('success', 'Permission berhasil diperbarui!');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index')
            ->with('success', 'Permission berhasil dihapus!');
    }
} 