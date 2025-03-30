@extends('layouts.app')

@section('title', 'Permission Details')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Permission Details</h1>
        <div class="flex space-x-2">
            <a href="{{ route('permissions.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Permissions
            </a>
            
            @if(auth()->user()->hasPermission('permissions.edit'))
            <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit Permission
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
                    <p class="text-lg">{{ $permission->name }}</p>
                </div>
                
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-500">Slug</h3>
                    <p class="text-lg">{{ $permission->slug }}</p>
                </div>
                
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-500">Description</h3>
                    <p class="text-lg">{{ $permission->description ?: 'No description' }}</p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Created At</h3>
                    <p class="text-lg">{{ $permission->created_at->format('d F Y, H:i') }}</p>
                </div>
            </div>
        </div>
        
        <div class="card shadow rounded-lg overflow-hidden">
            <div class="p-6">
                <h2 class="text-xl font-bold mb-4">Menu Information</h2>
                
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-500">Is Menu Item</h3>
                    <p class="text-lg">
                        @if($permission->is_menu)
                            <span class="text-green-600"><i class="fas fa-check-circle mr-1"></i> Yes</span>
                        @else
                            <span class="text-red-600"><i class="fas fa-times-circle mr-1"></i> No</span>
                        @endif
                    </p>
                </div>
                
                @if($permission->is_menu)
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Menu Group</h3>
                        <p class="text-lg">{{ $permission->menu_group ?: 'None' }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Menu Icon</h3>
                        <p class="text-lg">
                            @if($permission->menu_icon)
                                <i class="{{ $permission->menu_icon }} mr-2"></i> {{ $permission->menu_icon }}
                            @else
                                None
                            @endif
                        </p>
                    </div>
                    
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Menu Order</h3>
                        <p class="text-lg">{{ $permission->menu_order }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Parent Menu</h3>
                        <p class="text-lg">
                            @if($permission->parent)
                                {{ $permission->parent->name }}
                            @else
                                None (Top Level)
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="card shadow rounded-lg overflow-hidden md:col-span-2">
            <div class="p-6">
                <h2 class="text-xl font-bold mb-4">Roles with this Permission</h2>
                
                @if($permission->roles->isEmpty())
                    <p class="text-gray-500 italic">No roles have this permission</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($permission->roles as $role)
                            <div class="bg-blue-50 p-3 rounded-lg">
                                <h3 class="font-medium text-blue-700 mb-1">{{ $role->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $role->description ?: 'No description' }}</p>
                                <a href="{{ route('roles.show', $role) }}" class="text-blue-600 hover:underline text-sm mt-2 inline-block">
                                    <i class="fas fa-eye mr-1"></i> View Role
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        
        @if($permission->is_menu && $permission->children->count() > 0)
        <div class="card shadow rounded-lg overflow-hidden md:col-span-2">
            <div class="p-6">
                <h2 class="text-xl font-bold mb-4">Sub-Menu Items</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($permission->children as $child)
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <h3 class="font-medium text-gray-700 mb-1">{{ $child->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $child->description ?: 'No description' }}</p>
                            <p class="text-xs text-gray-500 mt-1">
                                <i class="{{ $child->menu_icon ?: 'fas fa-circle' }} mr-1"></i>
                                Order: {{ $child->menu_order }}
                            </p>
                            <a href="{{ route('permissions.show', $child) }}" class="text-blue-600 hover:underline text-sm mt-2 inline-block">
                                <i class="fas fa-eye mr-1"></i> View
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection 