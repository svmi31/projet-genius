<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filiere;
use App\Models\Etablissement;

class EtablissementController extends Controller
{
    public function create()
    {
        $filieres = Filiere::all();
        return view('inscription_e', compact('filieres'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nometat' => 'required|string|max:255',
            'ville' => 'nullable|string|max:255',
            'descriptetat' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'liensite' => 'nullable|string|max:255',
            'filieres' => 'array|required'
        ]);

        $etablissement = Etablissement::create([
            'nometat' => $data['nometat'],
            'ville' => $data['ville'] ?? null,
            'descriptetat' => $data['descriptetat'],
            'contact' => $data['contact'],
            'email' => $data['email'],
            'type' => $data['type'],
            'liensite' => $data['liensite'] ?? null,
        ]);

        $etablissement->filieres()->attach($data['filieres']);

        return redirect()->back()->with('success', 'Etablissement ajouté avec succès !');
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        $etablissements = Etablissement::with('filieres')
            ->when($search, function ($query, $search) {
                $query->where('nometat', 'like', "%{$search}%")
                      ->orWhere('ville', 'like', "%{$search}%")
                      ->orWhereHas('filieres', function ($q) use ($search) {
                          $q->where('nom','like', "%{$search}%");
                      });
            })
            ->get();

        return view('home', compact('etablissements'));
    }
}
