<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodePembayaran extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];
    protected $casts = [
        'is_Active' => 'boolean',
    ];
    public function scopeActive($query)
    {
        return $query->where('is_Active', true);
    }
    public function bisnis()
    {
        return $this->belongsTo(Bisnis::class);
    }
    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }
}
