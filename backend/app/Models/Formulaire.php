<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formulaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'amc_id',
        'donnees_formulaire',
        'fichier_excel',
    ];

    public function amc()
    {
        return $this->belongsTo(User::class, 'amc_id');
    }

        public function candidatures()
        {
            return $this->hasMany(Candidature::class);
        }

        public function exports()
        {
            return $this->hasMany(Export::class);
        }

        public function imports()
        {
            return $this->hasMany(Import::class);
        }

        public function notations()
        {
            return $this->hasMany(Notation::class);
        }

        public function statistiques()
        {
            return $this->hasMany(Statistique::class);
        }
}
