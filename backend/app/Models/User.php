<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nom',
        'email',
        'mot_de_passe',
        'role',
        'telephone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'mot_de_passe',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    // Pas de cast spécifique pour ce modèle

    // Relations Eloquent
    public function formulaires()
    {
        return $this->hasMany(Formulaire::class, 'amc_id');
    }

    public function candidatures()
    {
        return $this->hasMany(Candidature::class, 'amc_id');
    }

    /**
     * Indique à Laravel d'utiliser le champ mot_de_passe comme mot de passe.
     */
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }
}
