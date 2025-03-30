<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UseUuid;

class Permission extends Model
{
    use HasFactory, UseUuid;

    protected $fillable = [
        'name', 
        'slug', 
        'description', 
        'menu_group', 
        'menu_icon', 
        'menu_order',
        'is_menu',
        'parent_id'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    
    public function parent()
    {
        return $this->belongsTo(Permission::class, 'parent_id');
    }
    
    public function children()
    {
        return $this->hasMany(Permission::class, 'parent_id');
    }
    
    // Mendapatkan menu yang dapat diakses oleh role tertentu
    public static function getMenusByRole($roles)
    {
        $roleIds = $roles->pluck('id')->toArray();
        
        return self::whereHas('roles', function($query) use ($roleIds) {
                $query->whereIn('roles.id', $roleIds);
            })
            ->where('is_menu', true)
            ->orderBy('menu_group')
            ->orderBy('menu_order')
            ->get();
    }
} 