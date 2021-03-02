<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'parent_id'];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            // remove parent from this category's child
            foreach ($model->childs as $child) {
                $child->parent_id = '';
                $child->save();
            }
            // remove relations products
            $model->products()->detach();
        });
    }

    // childs digunakan mencari sub kategori, relasinya one-to-many
    public function childs()
    {
        // Kustomisasi relationship
        return $this->hasMany('App\Models\Category', 'parent_id');
    }

    // parent digunakan mencari parent dari sebuah category, relasinya many-to-one
    public function parent()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product');
    }

    // search category without parent
    public function scopeNoParent($query)
    {
        return $this->where('parent_id', '');
    }
}
