<?php

namespace App\Models;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipeBarang extends Model
{
    use HasFactory;

    protected $table = 'tipe_barang';

    public function getRouteKeyName()
    {
        return 'id';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_brand',
        'nama',
        'status_aktif',
        'created_by',
        'updated_by',
        'deleted_by',
        'restored_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'restored_at',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'id_brand', 'id');
    }
}
