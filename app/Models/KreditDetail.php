<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KreditDetail extends Model
{
    use HasFactory;

    protected $table = 'kredit_detail';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_kredit_nasabah',
        'gramasi',
        'no_seri',
        'image',
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
