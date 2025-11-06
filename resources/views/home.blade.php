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
    <title>Accueil - Liste des Etablissement</title>
</head>
<body class="bg-blue-50/25">
    <!-- header -->
    <header class="relative overflow-hidden rounded-2xl shadow-sm mb-8 bg-gradient-to-r from-blue-50 to-orange-50 border border-gray-200">
    <div class="px-6 py-12 sm:py-16 text-center">
        
        <!-- Titre -->
        <h1 class="text-4xl sm:text-5xl font-bold text-gray-800 mb-4">
            Découvrez les Établissements
        </h1>

        <!-- Sous-titre -->
        <p class="text-lg sm:text-xl text-gray-600 max-w-2xl mx-auto mb-8">
            Explorez les établissements et les différentes filières qu’ils proposent
        </p>

        <!-- Barre de recherche -->
        <form action="{{ route('etablissements.index') }}" method="get" 
              class="flex items-center justify-center max-w-xl mx-auto">
            
            <div class="relative w-full">
                <ion-icon name="search-outline" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-xl"></ion-icon>
                <input 
                    type="search" 
                    name="search" 
                    class="w-full border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 rounded-lg py-3 pl-10 pr-3 shadow-sm"
                    placeholder="Rechercher un établissement ou une filière..."
                >
            </div>

            <button 
                type="submit" 
                class="ml-3 px-5 py-3 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition duration-300 shadow-sm"
            >
                Rechercher
            </button>
        </form>

    </div>
</header>


    <nav>
        <button onclick="window.location.href='{{ route('admin') }}'" class=" w-14 h-14 cursor-pointer fixed bottom-8 right-4 bg-white border border-gray-300 shadow-lg rounded-full p-4 hover:bg-gray-100 hover:-translate-y-1.5 transition duration-300">
            <i class="ri-user-line text-orange-500 text-xl "></i>
        </button>
    </nav>

    <!-- contenue du site (liste des etablissement) -->
     
<section class="p-8 grid sm:grid-cols-2 md:grid-cols-3 gap-6">
    @if($etablissement->isEmpty())
        <p class="col-span-full text-center text-gray-500 text-lg">Aucun établissement trouvé.</p>
    @else
        @foreach ($etablissement as $etablissement)
        @if($etablissement->visible == true)
        <div class="border border-gray-200 shadow-lg rounded-xl overflow-hidden bg-white flex flex-col">
    @if(!$etablissement->photo)
        <div class="flex justify-center items-center py-26 mb-2 {{ $etablissement->type === 'Université Publique' ? 'bg-orange-100' : 'bg-blue-100' }}">
            <i class="{{ $etablissement->type === 'Université Publique' ? 'ri-graduation-cap-fill text-orange-500 text-5xl' : 'ri-building-4-line text-blue-500 text-5xl' }}"></i>
        </div>
    @else
        <div class="p-4">
            <img src="{{ asset('storage/' . $etablissement->photo) }}" alt="Photo {{ $etablissement->nometat }}" class="w-full max-h-64 object-cover rounded-lg shadow shadow-gray-600" />
        </div>
    @endif

    <div class="px-4 flex justify-between items-center">
        <h2 class="text-2xl w-2/3 font-bold text-gray-800">{{ $etablissement->descriptetat }} ({{ $etablissement->nometat }})</h2>
        <span class="{{ $etablissement->type === 'Université Publique' ? 'bg-orange-100 text-orange-500' : 'bg-blue-100 text-blue-500' }} text-sm font-medium p-1 rounded-lg">
            {{ $etablissement->type }}
        </span>
    </div>

    <div class="px-4 text-gray-500 mb-2">{{ $etablissement->ville }}</div>

    <div class="px-4 mb-4">
        <h3 class="font-medium mb-1 font-['poppins'] text-lg">Filières</h3>
        <ul class="grid grid-cols-2 gap-2">
            @foreach ($etablissement->filieres->take(3) as $filiere)
                <li class="border border-gray-200 rounded-lg text-center py-1 bg-gray-50">{{ $filiere->nom }}</li>
            @endforeach
            @if($etablissement->filieres->count() > 3)
                <li class="border border-gray-200 rounded-lg text-center py-1 bg-gray-100 text-gray-500">
                    +{{ $etablissement->filieres->count() - 3 }} autres
                </li>
            @endif
        </ul>
    </div>

    <div class="px-4 mb-4">
        <button onclick="ouvrir('modal-{{ $etablissement->id }}')" class="w-full py-2 rounded-lg text-white font-semibold transition duration-300 {{ $etablissement->type === 'Université Publique' ? 'bg-orange-500 hover:bg-orange-600' : 'bg-blue-500 hover:bg-blue-600' }}">
            Voir plus
        </button>
    </div>
</div>


        <!-- popup -->
<div id="modal-{{ $etablissement->id }}" 
     class="fixed inset-0 bg-gray-200/50 hidden items-center justify-center z-50 font-['poppins']"
     style="backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px); transition: opacity 0.3s ease;">
    <div class="bg-white rounded-xl w-11/12 sm:w-2/3 lg:w-2/5 p-4 relative shadow-2xl max-h-[90vh] overflow-y-auto">

        <button onclick="fermer('modal-{{ $etablissement->id }}')" 
                class="absolute top-0 right-4 text-gray-600 hover:text-red-500 text-3xl cursor-pointer transition-colors" 
                aria-label="Fermer le modal">&times;
        </button>

        <div class="w-full p-4 h-60 overflow-hidden ">
            @if(!$etablissement->photo)
            <div class="w-full h-full object-cover rounded-lg flex items-center justify-center bg-blue-100">
                <i class="ri-graduation-cap-line text-blue-950 text-5xl"></i>
            </div>
            @else
            <img src="{{ asset('storage/' . $etablissement->photo) }}"
                alt="Photo"
                class="w-full h-full object-cover rounded-lg shadow shadow-gray-600"/>
            @endif
        </div>
        <h2 class="font-bold text-2xl mb-2">
            {{ $etablissement->descriptetat }}({{ $etablissement->nometat }})
        </h2>

        <hr class="border-0 h-0.5 bg-gray-100 rounded my-1 mb-6 ">
        <h1 class="text-xl font-bold mb-4">
            <i class=" ri-building-4-line text-blue-950 text-xl"></i>
            Informations de contact
        </h1>
        <p class="mb-2.5 flex items-center gap-2 text-gray-700 text-sm">
            <i class="ri-map-pin-2-fill text-gray-700"></i>
             {{ $etablissement->ville }}
        </p>

        <p class="mb-2.5 flex items-center gap-2 text-gray-700 text-sm">
            <i class="ri-bank-fill text-gray-700"></i>
            {{ $etablissement->type }}
        </p>

        @if($etablissement->liensite)
        <p class="mb-2.5 flex items-center gap-2 text-gray-700 text-sm">
            <i class="ri-links-fill text-gray-700"></i>
            <a href="{{ $etablissement->liensite }}" target="_blank" class="text-blue-600 hover:text-blue-800 transition">
                {{ $etablissement->liensite }}
            </a>
        </p>
        @endif
        <p class="mb-2.5 flex items-center gap-2 text-gray-700 text-sm">
            <i class="ri-phone-line"></i>
            {{ $etablissement->contact }}
        </p>
        <p class="mb-6 flex items-center gap-2 text-gray-700 text-sm">
            <i class="ri-mail-line"></i> 
            <a href="mailto:{{ $etablissement->email }}" target="_blank" class="text-blue-600 hover:text-blue-800 transition">
                {{ $etablissement->email }}
            </a>
        </p>
        <hr class="border-0 h-0.5 bg-gray-200 rounded my-1 mb-8 ">
        <h3 class="text-xl font-semibold mb-3 flex items-center gap-3 text-black">
            <i class="ri-graduation-cap-line text-blue-950 text-2xl"></i> Toutes les filières ({{$etablissement->filieres->count()}})
        </h3>
        @if($etablissement->filieres->count() > 6)

    <ul class="gap-2 grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 text-gray-800 space-y-1">

        @forelse ($etablissement->filieres as $filiere)
            <li class="flex gap-3 items-start border border-gray-200 rounded-xl p-2 shadow-sm hover:shadow-md transition">
                <i class="ri-checkbox-circle-fill text-green-600 text-2xl"></i>
                <div>
                    <p class="font-semibold text-gray-800">{{ $filiere->nom }}</p>
                    <p class="text-gray-600 text-sm mt-1">{{ $filiere->descript }}</p>
                </div>
            </li>
        @empty
            <li>Aucune filière disponible</li>
        @endforelse

    </ul>

@else

    <ul class="gap-2 grid grid-cols-2 sm:grid-cols-2 md:grid-cols-1 text-gray-800 space-y-1">

        @forelse ($etablissement->filieres as $filiere)
            <li class="flex gap-3 items-start border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition">
                <i class="ri-checkbox-circle-fill text-green-600 text-2xl"></i>
                <div>
                    <p class="font-semibold text-gray-800">{{ $filiere->nom }}</p>
                    <p class="text-gray-600 text-sm mt-1">{{ $filiere->descript }}</p>
                </div>
            </li>
        @empty
            <li>Aucune filière disponible</li>
        @endforelse

    </ul>
@endif
<button onclick="fermer('modal-{{ $etablissement->id }}')" 
                class="text-gray-600 hover:text-red-500 text-lg cursor-pointer transition-colors" 
                aria-label="Fermer le modal">Fermer
        </button>
    </div>
</div>
            @endif
        @endforeach
    @endif

</section>
</body>

<script >
    function ouvrir(id){
    document.getElementById(id).classList.remove('hidden');
    document.getElementById(id).classList.add('flex');
}

function fermer(id){
    document.getElementById(id).classList.remove('flex');
    document.getElementById(id).classList.add('hidden');
}
</script>

</html>