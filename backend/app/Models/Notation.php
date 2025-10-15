<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notation extends Model
{
    use HasFactory;

    protected $fillable = [
        'jury_id',
        'infos_candidat',
        'reponses_notation',
        'note_totale',
        'fichier_pdf',
    ];

    public function jury()
    {
        return $this->belongsTo(User::class, 'jury_id');
    }
}
