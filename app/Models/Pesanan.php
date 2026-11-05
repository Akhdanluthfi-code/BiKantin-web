<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'menu_id',
        'jumlah',
        'total_harga',
        'status',
        'status_pembayaran',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'menu_id' => 'integer',
        'jumlah' => 'integer',
        'total_harga' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
