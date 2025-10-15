<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Export extends Model
{
    use HasFactory;

    protected $fillable = [
        'cms_id',
        'fichier_nom',
        'fichier_url',
        'type_export',
    ];

    public function cms()
    {
        return $this->belongsTo(User::class, 'cms_id');
    }
}
