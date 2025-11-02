<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\Filiere;

class AdminController extends Controller
{
     public function index()
    {
        $etablissements = Etablissement::with('filieres')->get();
         $filieres = Filiere::all();

        // Rendre la vue et passer la variable
        return view('edit', compact('etablissements'));
        // ou: return view('admin.dashboard')->with('etablissements', $etablissements);
    }
}
