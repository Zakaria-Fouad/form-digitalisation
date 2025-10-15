<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    use HasFactory;

    protected $fillable = [
        'jury_id',
        'fichier_nom',
        'fichier_url',
        'date_import',
    ];

    public function jury()
    {
        return $this->belongsTo(User::class, 'jury_id');
    }
}
