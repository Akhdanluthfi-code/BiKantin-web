<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';

    public $timestamps = false;

    protected $fillable = [
        'nama_menu',
        'harga',
        'kategori',
        'deskripsi',
        'foto',
    ];

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'menu_id');
    }
}
