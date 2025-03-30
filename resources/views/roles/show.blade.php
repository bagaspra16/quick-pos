@extends('layouts.app')

@section('title', 'Role Details')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Role Details</h1>
        <div class="flex space-x-2">
            <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Roles
            </a>
            
            @if(auth()->user()->hasPermission('roles.edit'))
            <a href="{{ route('roles.edit', $role) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit Role
            </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="card shadow rounded-lg overflow-hidden">
            <div class="p-6">
                <h2 class="text-xl font-bold mb-4">Basic Information</h2>
                
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-500">Name</h3>
                    <p class="text-lg">{{ $role->name }}</p>
                </div>
                
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-500">Description</h3>
                    <p class="text-lg">{{ $role->description ?: 'No description' }}</p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Users with this role</h3>
                    <p class="text-lg">{{ $role->users->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="card shadow rounded-lg overflow-hidden md:col-span-1">
            <div class="p-6">
                <h2 class="text-xl font-bold mb-4">Users with this Role</h2>
                
                @if($role->users->isEmpty())
                    <p class="text-gray-500 italic">No users assigned to this role</p>
                @else
                    <div class="space-y-2">
                        @foreach($role->users as $user)
                            <div class="bg-blue-50 p-3 rounded-lg flex items-center justify-between">
                                <div>
                                    <h3 class="font-medium text-blue-700">{{ $user->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                </div>
                                
                                <a href="{{ route('users.show', $user) }}" class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        
        <div class="card shadow rounded-lg overflow-hidden md:col-span-2">
            <div class="p-6">
                <h2 class="text-xl font-bold mb-4">Permissions</h2>
                
                @php
                    $permissionsByGroup = $role->permissions->groupBy('menu_group');
                @endphp
                
                @if($role->permissions->isEmpty())
                    <p class="text-gray-500 italic">No permissions assigned</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($permissionsByGroup as $group => $permissions)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="font-bold text-gray-700 mb-3">{{ $group ?: 'Other' }}</h3>
                                <ul class="space-y-1">
                                    @foreach($permissions as $permission)
                                        <li class="flex items-center text-sm">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            {{ $permission->name }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 