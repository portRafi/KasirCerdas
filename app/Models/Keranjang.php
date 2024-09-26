<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        
    ];

    public function metodePembayaran()
    {
        return $this->belongsTo(MetodePembayaran::class, 'id');
    }

}
