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

        Filiere::create([
            'nom' => $request->nom,
            'descript' => $request->descript,
        ]);

        // ✅ message de confirmation
        return redirect()->back()->with('success', 'Filière ajoutée avec succès !');
    }
}
