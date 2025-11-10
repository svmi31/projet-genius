<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\Filiere;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function select()
    {
        return view('login');
    }

    public function show(Request $request)
    {
        $id = $request->input('id');
        $etablissement = Etablissement::with('filieres')->find($id);

        if (!$etablissement) {
            return redirect()->back()->withErrors('Établissement non trouvé avec cet ID.');
        }

        return view('admin_e', compact('etablissement'));
    }