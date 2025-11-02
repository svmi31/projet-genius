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
            'filieres' => 'array',
            'nouvelle_filiere' => 'nullable|string|max:255'
        ]);

        // Création de l’établissement
        $etablissement = Etablissement::create([
            'nometat' => $data['nometat'],
            'ville' => $data['ville'] ?? null,
            'descriptetat' => $data['descriptetat'],
            'contact' => $data['contact'],
            'email' => $data['email'],
            'type' => $data['type'],
            'liensite' => $data['liensite'] ?? null,
        ]);

        //  Récupération des filières cochées
        $filiereIds = $data['filieres'] ?? [];

        // Si une nouvelle filière est ajoutée
        if (!empty($request->nouvelle_filiere)) {
            $newFiliere = Filiere::create([
                'nom' => $request->nouvelle_filiere,
                'descript' => 'Ajoutée automatiquement'
            ]);

            // Ajouter son ID à la liste
            $filiereIds[] = $newFiliere->id;
        }

        // Attacher toutes les filières (cochées + nouvelle)
        $etablissement->filieres()->attach($filiereIds);

        return redirect()->back()->with('success', 'Établissement ajouté avec succès !');
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        $etablissement = Etablissement::with('filieres')
            ->when($search, function ($query, $search) {
                $query->where('nometat', 'like', "%{$search}%")
                      ->orWhere('ville', 'like', "%{$search}%")
                      ->orWhereHas('filieres', function ($q) use ($search) {
                          $q->where('nom', 'like', "%{$search}%");
                      });
            })
            ->get();

        return view('home', compact('etablissement'));
    }
    public function update(Request $request, $id)
{
    $request->validate([
        'nometat'          => 'required|string|max:255',
        'ville'            => 'nullable|string|max:255',
        'descriptetat'     => 'required|string|max:255',
        'contact'          => 'required|string|max:255',
        'email'            => 'required|email|max:255',
        'type'             => 'required|string|max:255',
        'liensite'         => 'nullable|string|max:255',
        'filieres'         => 'array',
        'filieres.*'       => 'integer|exists:filieres,id',
        'nouvelle_filiere' => 'nullable|string|max:255'
    ]);

    // ✅ Récupération de l'établissement
    $etablissement = Etablissement::findOrFail($id);
     $filieres = Filiere::all();

    // ✅ Liste des filières choisies dans les checkboxes
    $filiereIds = $request->filieres ?? [];

    // ✅ Création d'une nouvelle filière si fournie
    if (!empty($request->nouvelle_filiere)) {

        // Vérifier si elle existe pour éviter les doublons
        $existing = Filiere::whereRaw("LOWER(nom) = ?", [strtolower($request->nouvelle_filiere)])->first();

        if ($existing) {
            $newFiliereId = $existing->id;
        } else {
            $newFiliere = Filiere::create([
                'nom'      => $request->nouvelle_filiere,
                'descript' => 'Ajoutée automatiquement'
            ]);
            $newFiliereId = $newFiliere->id;
        }

        // Ajouter l'ID dans la liste des filières à synchroniser
        $filiereIds[] = $newFiliereId;
    }

    // ✅ Mise à jour des champs principaux
    $etablissement->update([
        'nometat'      => $request->nometat,
        'ville'        => $request->ville,
        'descriptetat' => $request->descriptetat,
        'contact'      => $request->contact,
        'email'        => $request->email,
        'type'         => $request->type,
        'liensite'     => $request->liensite,
    ]);

    // ✅ Mise à jour de la relation plusieurs-à-plusieurs
    $etablissement->filieres()->sync($filiereIds);

    return redirect()
        ->route('admin');
}

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
{
    $etablissement = Etablissement::findOrFail($id);

    // Supprimer ses relations avec les filières pour éviter les erreurs
    $etablissement->filieres()->detach();

    // Supprimer l'établissement
    $etablissement->delete();

    return redirect()->route('admin')
        ->with('success', 'Établissement supprimé avec succès ✅');
}

 public function admin()
{
    $etablissements = Etablissement::with('filieres')->get();
    $filieres = Filiere::all();

    return view('admin', compact('etablissements', 'filieres'));
}

public function edit($id)
{
    $etablissement = Etablissement::findOrFail($id);
    $filieres = Filiere::all();

    return view('edit', compact('etablissement', 'filieres'));
}


}