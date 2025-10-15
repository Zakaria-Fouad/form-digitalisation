<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
    use HasFactory;

    protected $fillable = [
        'amc_id',
        'form_data',
        'status',
        'excel_row',
    ];

    public function amc()
    {
        return $this->belongsTo(User::class, 'amc_id');
    }
}
