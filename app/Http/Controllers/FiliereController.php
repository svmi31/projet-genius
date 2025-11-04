<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filiere; // importer le modèle

class FiliereController extends Controller
{
    public function create()
    {
        return view('inscription');
    }

    public function store(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'descript' => 'required|string|max:255',
    ]);
    
    $existe = Filiere::whereRaw("LOWER(TRIM(nom)) = ?", [ strtolower(trim($request->nom)) ])->first();

    if ($existe) {
        return redirect()->back()->with('error', 'Cette filière existe déjà.');
    }

    Filiere::create([
        'nom' => $request->nom,
        'descript' => $request->descript,
    ]);

    return redirect()->back()->with('success', 'Filière ajoutée avec succès !');
}

}
