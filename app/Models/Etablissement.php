<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Filiere;

class Etablissement extends Model
{
    use HasFactory;

    protected $fillable = [
        'nometat',
        'ville',
        'descriptetat',
        'contact',
        'email',
        'liensite',
        'type'
    ];

    public function filieres()
    {
        return $this->belongsToMany(Filiere::class, 'etatfil');
    }
}
