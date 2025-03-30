<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UseUuid;

class Role extends Model
{
    use HasFactory, UseUuid;

    protected $fillable = ['name', 'description'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    
    // Method untuk memeriksa jika role memiliki permission tertentu
    public function hasPermission($permission)
    {
        if (is_string($permission)) {
            return $this->permissions->where('slug', $permission)->count() > 0;
        }
        
        return $permission->intersect($this->permissions)->count() > 0;
    }
    
    // Method untuk memberikan permission ke role
    public function givePermissionTo($permission)
    {
        $this->permissions()->save($permission);
    }
} 