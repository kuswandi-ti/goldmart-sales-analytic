<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerVisit extends Model
{
    use HasFactory;

    protected $table = 'customer_visit';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'no_dokumen',
        'tgl_visit',
        'tahun',
        'bulan',
        'week',
        'quarter',
        'nama_customer',
        'parameter_1',
        'parameter_2',
        'parameter_3',
        'parameter_4',
        'id_sales_person',
        'kode_sales',
        'nama_sales',
        'id_store',
        'kode_store',
        'nama_store',
        'kota_store',
        'created_by',
        'updated_by',
        'deleted_by',
        'restored_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'restored_at',
    ];

    public function scopePeriodeAktif($query)
    {
        return $query->where('tahun', activePeriod());
    }
}
