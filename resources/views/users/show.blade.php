@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">User Details</h1>
        <div class="flex space-x-2">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Users
            </a>
            
            @if(auth()->user()->hasPermission('users.edit'))
            <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit User
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
                    <p class="text-lg">{{ $user->name }}</p>
                </div>
                
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-500">Email</h3>
                    <p class="text-lg">{{ $user->email }}</p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Created At</h3>
                    <p class="text-lg">{{ $user->created_at->format('d F Y, H:i') }}</p>
                </div>
            </div>
        </div>
        
        <div class="card shadow rounded-lg overflow-hidden">
            <div class="p-6">
                <h2 class="text-xl font-bold mb-4">Roles</h2>
                
                @if($user->roles->isEmpty())
                    <p class="text-gray-500 italic">No roles assigned</p>
                @else
                    <div class="grid grid-cols-1 gap-2">
                        @foreach($user->roles as $role)
                            <div class="bg-blue-50 p-3 rounded-lg">
                                <h3 class="font-medium text-blue-700">{{ $role->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $role->description ?: 'No description' }}</p>
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
                    $allPermissions = collect();
                    foreach($user->roles as $role) {
                        $allPermissions = $allPermissions->merge($role->permissions);
                    }
                    $allPermissions = $allPermissions->unique('id');
                    $permissionsByGroup = $allPermissions->groupBy('menu_group');
                @endphp
                
                @if($allPermissions->isEmpty())
                    <p class="text-gray-500 italic">No permissions available</p>
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