<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesPerson extends Model
{
    use HasFactory;

    protected $table = 'sales_person';

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode',
        'slug',
        'nama',
        'nik',
        'id_store',
        'kode_store',
        'nama_store',
        'kota_store',
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

    public function scopeActive($query)
    {
        return $query->where('status_aktif', 1);
    }

    public function scopeNonActive($query)
    {
        return $query->where('status_aktif', 0);
    }
}
