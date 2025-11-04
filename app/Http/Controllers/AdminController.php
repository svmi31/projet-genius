<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etablissement;

class AdminController extends Controller
{
    // Affiche la page avec le formulaire de saisie ID
    public function select()
    {
        return view('login');
    }

    // Affiche les infos de l'établissement selon l'ID saisi
    public function show(Request $request)
    {
        $id = $request->input('id');
        $etablissement = Etablissement::with('filieres')->find($id);

        if (!$etablissement) {
            return redirect()->back()->withErrors('Établissement non trouvé avec cet ID.');
        }

        return view('admin_e', compact('etablissement'));
    }
}
