<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['kode', 'nama'];

    // Relasi Many to Many ke MasterItem
    // Argumen: (ModelTujuan, NamaTabelPivot, FK_model_ini, FK_model_tujuan)
    public function items()
    {
        return $this->belongsToMany(MasterItem::class, 'category_item', 'category_id', 'master_item_id');
    }
}