<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerVisitDetail extends Model
{
    use HasFactory;

    protected $table = 'customer_visit_detail';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_visit',
        'parameter_main',
        'parameter_1',
        'parameter_2',
        'parameter_3',
        'qty',
        'nominal',
        'keterangan',
        'created_by',
        'updated_by',
        'deleted_by',
        'restored_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'restored_at',
    ];
}
