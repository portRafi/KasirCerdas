<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTransaksi extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];
    public function bisnis()
    {
        return $this->belongsTo(Bisnis::class);
    }
    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }
}
