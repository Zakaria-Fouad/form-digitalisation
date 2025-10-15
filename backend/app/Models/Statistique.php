<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistique extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_amc',
        'total_jury',
        'total_formulaires',
        'total_exports',
        'total_notations',
        'last_update',
    ];
}
