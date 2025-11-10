<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filiere;
use App\Models\Etablissement;
use Illuminate\Support\Facades\Storage;

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
        'nometat'          => 'required|string|max:255',
        'ville'            => 'nullable|string|max:255',
        'descriptetat'     => 'required|string|max:255',
        'contact'          => 'nullable|string|max:255',
        'email'            => 'nullable|string|max:255',
        'type'             => 'required|string|max:255',
        'liensite'         => 'nullable|string|max:255',
        'filieres'         => 'array',
        'nouvelle_filiere' => 'nullable|string|max:255',
        'photo'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Vérifier doublon AVANT tout
    $nom = strtolower(trim($request->nometat));

    $existe = Etablissement::whereRaw("LOWER(TRIM(nometat)) = ?", [$nom])->exists();

    if ($existe) {
        return redirect()->back()->with('error', 'Cet établissement existe déjà.');
    }

    // Upload photo
    $photoPath = null;

    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('photos', 'public');
    }

    // Création établissement
    $etablissement = Etablissement::create([
        'nometat'      => $data['nometat'],
        'ville'        => $data['ville'] ?? null,
        'descriptetat' => $data['descriptetat'],
        'contact'      => $data['contact'],
        'email'        => $data['email'],
        'type'         => $data['type'],
        'liensite'     => $data['liensite'] ?? null,
        'photo'        => $photoPath,
        'visible'      => false,
    ]);

    // Gestion filières
    $filiereIds = $data['filieres'] ?? [];

    if (!empty($request->nouvelle_filiere)) {
        $newFiliere = Filiere::create([
            'nom'      => $request->nouvelle_filiere,
            'descript' => 'Ajoutée automatiquement'
        ]);

        $filiereIds[] = $newFiliere->id;
    }

    // Attacher sans doublon
    $etablissement->filieres()->syncWithoutDetaching($filiereIds);

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
// mofication etablissement
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
            'nouvelle_filiere' => 'nullable|string|max:255',
            'photo'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $etablissement = Etablissement::findOrFail($id);

        // changement de photo

        if ($request->hasFile('photo')) {

            // Supprimer l’ancienne photo 

            if ($etablissement->photo && Storage::disk('public')->exists($etablissement->photo)) {
                Storage::disk('public')->delete($etablissement->photo);
            }

            // ajouter nouvelle photo
            $photoPath = $request->file('photo')->store('photos', 'public');
        } else {
            $photoPath = $etablissement->photo; // sinon on garde l’ancienne
        }

        //  liste des filières

        $filiereIds = $request->filieres ?? [];

        //  nouvelle filière si ajoutée

        if (!empty($request->nouvelle_filiere)) {

            $existing = Filiere::whereRaw("LOWER(nom) = ?", [strtolower($request->nouvelle_filiere)])->first();

            if ($existing) {
                $filiereIds[] = $existing->id;
            } else {
                $newFiliere = Filiere::create([
                    'nom'      => $request->nouvelle_filiere,
                    'descript' => ''
                ]);
                $filiereIds[] = $newFiliere->id;
            }
        }

        //  mise à jour

        $etablissement->update([
            'nometat'      => $request->nometat,
            'ville'        => $request->ville,
            'descriptetat' => $request->descriptetat,
            'contact'      => $request->contact,
            'email'        => $request->email,
            'type'         => $request->type,
            'liensite'     => $request->liensite,
            'photo'        => $photoPath,
        ]);

        //  Sync filières

        $etablissement->filieres()->sync($filiereIds);

        return redirect()->route('admin')->with('success', 'Mise à jour réussie ');
    }
// suppression etablissement
    public function destroy($id)
    {
        $etablissement = Etablissement::findOrFail($id);

        //  Supprimer photo associée

        if ($etablissement->photo && Storage::disk('public')->exists($etablissement->photo)) {
            Storage::disk('public')->delete($etablissement->photo);
        }

        //  Supprimer relations

        $etablissement->filieres()->detach();

        //  Supprimer établissement

        $etablissement->delete();

        return redirect()->route('admin')->with('success', 'Établissement supprimé ');
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
    public function toggleVisible(Etablissement $etablissement)
{
    $etablissement->visible = !$etablissement->visible;
    $etablissement->save();

    return redirect()->back()->with('success', 'Visibilité de l\'établissement mise à jour.');
}

}
