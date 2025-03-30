@extends('layouts.app')

@section('title', 'Edit Permission')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Edit Permission: {{ $permission->name }}</h1>
        <a href="{{ route('permissions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Permissions
        </a>
    </div>

    <div class="card shadow rounded-lg overflow-hidden">
        <div class="p-6">
            <form action="{{ route('permissions.update', $permission) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $permission->name) }}" 
                        class="form-input w-full rounded-md shadow-sm border-gray-300 @error('name') border-red-500 @enderror" 
                        required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug', $permission->slug) }}" 
                        class="form-input w-full rounded-md shadow-sm border-gray-300 @error('slug') border-red-500 @enderror"
                        required>
                    <p class="text-xs text-gray-500 mt-1">Used for checking permissions. Be careful when changing this.</p>
                    @error('slug')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea id="description" name="description" rows="2" 
                        class="form-textarea w-full rounded-md shadow-sm border-gray-300 @error('description') border-red-500 @enderror">{{ old('description', $permission->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4 flex items-center">
                    <input type="checkbox" id="is_menu" name="is_menu" value="1" class="h-4 w-4 text-indigo-600 border-gray-300 rounded"
                        {{ old('is_menu', $permission->is_menu) ? 'checked' : '' }}>
                    <label for="is_menu" class="ml-2 block text-sm text-gray-900">
                        Show as Menu Item
                    </label>
                </div>
                
                <div id="menuOptions" class="mb-4 p-4 border border-gray-200 rounded-md {{ old('is_menu', $permission->is_menu) ? '' : 'hidden' }}">
                    <h3 class="text-lg font-medium mb-3">Menu Options</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="menu_group" class="block text-sm font-medium text-gray-700 mb-1">Menu Group</label>
                            <input type="text" id="menu_group" name="menu_group" value="{{ old('menu_group', $permission->menu_group) }}" 
                                class="form-input w-full rounded-md shadow-sm border-gray-300"
                                placeholder="e.g. Main, Settings">
                            <p class="text-xs text-gray-500 mt-1">Used for grouping menu items in the sidebar</p>
                        </div>
                        
                        <div>
                            <label for="menu_icon" class="block text-sm font-medium text-gray-700 mb-1">Menu Icon</label>
                            <input type="text" id="menu_icon" name="menu_icon" value="{{ old('menu_icon', $permission->menu_icon) }}" 
                                class="form-input w-full rounded-md shadow-sm border-gray-300"
                                placeholder="e.g. fas fa-users">
                            <p class="text-xs text-gray-500 mt-1">FontAwesome icon class</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="menu_order" class="block text-sm font-medium text-gray-700 mb-1">Menu Order</label>
                            <input type="number" id="menu_order" name="menu_order" value="{{ old('menu_order', $permission->menu_order) }}" 
                                class="form-input w-full rounded-md shadow-sm border-gray-300">
                            <p class="text-xs text-gray-500 mt-1">Order within the menu group</p>
                        </div>
                        
                        <div>
                            <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1">Parent Menu</label>
                            <select id="parent_id" name="parent_id" class="form-select w-full rounded-md shadow-sm border-gray-300">
                                <option value="">-- No Parent --</option>
                                @foreach($parentPermissions as $parent)
                                    <option value="{{ $parent->id }}" {{ old('parent_id', $permission->parent_id) == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->name }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">For submenu items</p>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end mt-6">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Permission
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isMenuCheckbox = document.getElementById('is_menu');
        const menuOptions = document.getElementById('menuOptions');
        
        isMenuCheckbox.addEventListener('change', function() {
            if (this.checked) {
                menuOptions.classList.remove('hidden');
            } else {
                menuOptions.classList.add('hidden');
            }
        });
    });
</script>
@endsection 