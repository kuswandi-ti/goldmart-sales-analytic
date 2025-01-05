<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewKreditNasabah extends Model
{
    use HasFactory;

    protected $table = 'view_kredit_nasabah';

    public function scopePeriode($query)
    {
        return $query->where('tahun', activePeriod());
    }
}
