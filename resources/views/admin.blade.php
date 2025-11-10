<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
     @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    <title>Dashboard Administrateur</title>
</head>
<style>
  .action-btn {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }
        .action-btn:hover {
            transform: scale(1.15) rotate(5deg);
        }
</style>

<body class="bg-cyan-50/30 font-[Poppins]"> 

<div>   
     <div class="flex-1 flex flex-col">

      <!-- Header -->
      <header class="flex fixed z-50 w-full justify-between items-center p-8 mb-16 shadow bg-white dark:bg-gray-800">
        <h2 class="text-2xl font-semibold">Dashboard Admin</h2>
        <button>
            <a href="{{ route('etablissements.index') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Retourner à l'accueil</a>
        </button>
      </header>

      <main class="p-6 overflow-auto mt-24 flex-1">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
          <div class="bg-blue-50 border border-blue-200 p-8 rounded-lg shadow-sm hover:shadow-md">
            <div class="flex flex-row justify-between w-full  mb-3">
              <h3 class="text-gray-500">Total Etablissements</h3>
              <i class="ri-graduation-cap-line text-xl text-gray-400" ></i>
            </div>
            <p class="text-6xl font-bold">{{ $etablissements->count() }}</p>
          </div>
          <div class="bg-indigo-50 border border-indigo-200 p-8 rounded-lg shadow-sm hover:shadow-md">
            <div class="flex flex-row justify-between w-full mb-3">
              <h3 class="text-gray-500 ">Totales Filières</h3>
              <i class="ri-book-open-line text-xl text-gray-500"></i>
            </div>
            <p class="text-6xl font-bold">{{ $filieres->count() }}</p>
          </div>
        </div>

        <div class="bg-white p-8 rounded-lg shadow shadow-gray-400">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold mb-4">Etablissements</h3>
                <a href="{{ route('etablissement.create') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    <i class="ri-add-line"></i> Ajouter un établissement
            </a>
            </div>
            <div class="overflow-x-auto">
              <table class="min-w-full border border-gray-200">
            <thead class="bg-gray-50">
        <tr>
            <th class="p-4 text-left"></th>
            <th class="p-4 text-left">Nom de l'établissement</th>
            <th class="p-4 text-left">Sigle</th>
            <th class="p-4 text-left">Filière</th>
            <th class="p-4 text-left">Email</th>
            <th class="p-4 text-left">Type</th>
            <th class="p-4 text-left">Ville</th>
            <th class="p-4 text-left">Site web</th>
            <th class="p-4 text-left"></th>
        </tr>
    </thead>

    <tbody class="divide-y overflow-x-auto divide-gray-200">
        @foreach ($etablissements as $etablissement)
        <tr class="hover:bg-blue-50">
            <td class="p-4">
                @if(!$etablissement->photo)
                    <div class="flex items-center justify-center bg-blue-100 p-4 rounded-full">
                        <i class="ri-graduation-cap-line text-2xl"></i>
                    </div>
                @else
                    <img src="{{ asset('storage/' . $etablissement->photo) }}" 
                         alt="" class="w-32 h-20 rounded-full object-cover">
                @endif
            </td>
            <td class="p-4">{{ $etablissement->descriptetat }}</td>
            <td class="p-4">{{ $etablissement->nometat }}</td>
            <td class="p-4 text-center">
              @if($etablissement->filieres->count() > 0)
              <p class="font-bold">{{ $etablissement->filieres->count()}}</p>
              @else
                <p class="text-gray-500">Aucune</p>
              @endif
            </td>
            <td class="p-4"> {{ $etablissement->email ?? 'N/A' }}</td>
            <td class="p-4 text-center">{{ $etablissement->type }}</td>
            <td class="p-4 text-center">{{ $etablissement->ville ?? 'N/A' }}</td>
            <td class="px-6 py-5">
                @if($etablissement->liensite)
                    <a href="{{ $etablissement->liensite }}" 
                        target="_blank" 
                        class="inline-flex items-center gap-2 px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition text-sm font-medium">
                        <i class="ri-external-link-line"></i>
                        <span>Visiter</span>
                        </a>
                @else
                  <span class="text-gray-400 text-sm">N/A</span>
                @endif
            </td>
            <td class="px-6 py-5">
                                <div class="flex items-center justify-center gap-2">
                                    
                                    <!-- Modifier -->
                                    <button onclick="window.location.href='{{ route('etablissement.edit', $etablissement->id) }}'" 
                                            class="action-btn w-11 h-11 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-100 flex items-center justify-center shadow-md"
                                            title="Modifier">
                                        <i class="ri-edit-line text-lg"></i>
                                    </button>

                                    <!-- Visibilité -->
                                    <form action="{{ route('etablissement.toggleVisible', $etablissement->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="action-btn w-11 h-11 rounded-xl flex items-center justify-center shadow-md
                                                {{ $etablissement->visible && $etablissement->filieres->count() > 0 ? 'bg-green-50 text-green-600 hover:bg-green-100' : 'bg-gray-50 text-gray-400 hover:bg-gray-100' }}"
                                                title="{{ $etablissement->visible ? 'Visible' : 'Caché' }}">
                                            <i class="{{ $etablissement->visible && $etablissement->filieres->count() > 0 ? 'ri-eye-line' : 'ri-eye-off-line' }} text-lg"></i>
                                        </button>
                                    </form>

                                    <!-- Supprimer -->
                                    <form action="{{ route('etablissement.destroy', $etablissement->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet établissement ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="action-btn w-11 h-11 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 flex items-center justify-center shadow-md"
                                                title="Supprimer">
                                            <i class="ri-delete-bin-line text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>

        </tr>
        @endforeach
    </tbody>
</table>
            </div>

        </div>
      </main>
    </div>
  </div>
</body>
</html>
