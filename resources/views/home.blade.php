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
                        class="max-w-2xl mx-auto">
                    <div class="glass-effect rounded-2xl shadow-2xl p-2 flex items-center gap-2">
                        <div class="relative flex-1">
                            <ion-icon name="search-outline" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xl"></ion-icon>
                            <input 
                                type="search" 
                                name="search" 
                                class="w-full border-0 focus:ring-0 search-glow rounded-xl py-4 pl-12 pr-4 bg-transparent text-gray-700 placeholder-gray-400"
                                placeholder="Rechercher un établissement, une filière, une ville..."
                            >
                        </div>
                        <button 
                            type="submit" 
                            class="px-8 py-4 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold hover:from-blue-700 hover:to-purple-700 transition duration-300 shadow-lg hover:shadow-xl flex items-center gap-2"
                        >
                            <span>Rechercher</span>
                            <i class="ri-arrow-right-line"></i>
                        </button>
                    </div>
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
        <span class="{{ $etablissement->type === 'Grande-École' ? 'bg-blue-100 text-blue-500' : 'bg-orange-100 text-orange-500' }} text-sm font-medium p-1 rounded-lg">
            {{ $etablissement->type }}
        </span>
    </div>

    <div class="px-4 text-gray-500 mb-2">{{ $etablissement->ville }}</div>

    <div class="px-4 mb-4">
        <h3 class="font-medium mb-1 font-['poppins'] text-lg">Filières</h3>
        <ul class="grid grid-cols-2 gap-2">
            @foreach ($etablissement->filieres->take(3) as $filiere)
                <li class="{{ $etablissement->type == 'Grande-École' ? 'border border-blue-200 rounded-lg text-center py-1 bg-blue-50' : 'border border-orange-200 rounded-lg text-center py-1 bg-orange-50'}}">{{ $filiere->nom }}</li>
            @endforeach
            @if($etablissement->filieres->count() > 3)
                <li class="border border-gray-200 rounded-lg text-center py-1 bg-gray-100 text-gray-500">
                    +{{ $etablissement->filieres->count() - 3 }} autres
                </li>
            @endif
        </ul>
    </div>

    <div class="px-4 mb-4">
        <button onclick="ouvrir('modal-{{ $etablissement->id }}')" class="w-full py-3 rounded-lg text-white cursor-pointer font-semibold transition duration-300 {{ $etablissement->type === 'Grande-École' ? 'bg-blue-500 hover:bg-blue-600' : 'bg-orange-500 hover:bg-orange-600' }}">
            Voir plus
        </button>
    </div>
</div>


        <!-- popup -->
        <div id="modal-{{ $etablissement->id }}" 
                     class="fixed inset-0 bg-black/50 modal-backdrop hidden items-center justify-center z-50 p-4"
                     onclick="if(event.target === this) fermer('modal-{{ $etablissement->id }}')">
                    <div class="bg-white rounded-3xl w-full max-w-3xl max-h-[90vh] overflow-y-auto shadow-2xl animate-fade-in"
                         onclick="event.stopPropagation()">
                        
                        <!-- Header du modal -->
                        <div class="sticky top-0 z-10 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between rounded-t-3xl">
                            <h2 class="text-2xl font-bold text-gray-900">Détails de l'établissement</h2>
                            <button onclick="fermer('modal-{{ $etablissement->id }}')" 
                                    class="w-10 h-10 rounded-full hover:bg-gray-100 transition flex items-center cursor-pointer justify-center text-gray-600 hover:text-red-500">
                                <i class="ri-close-line text-2xl"></i>
                            </button>
                        </div>

                        <div class="p-6">
                            <!-- Image -->
                            @if(!$etablissement->photo)
                            <div class="w-full h-64 rounded-2xl flex items-center justify-center bg-gradient-to-br from-blue-100 to-pink-100 mb-6">
                                <i class="ri-graduation-cap-line text-blue-600 text-7xl"></i>
                            </div>
                            @else
                            <img src="{{ asset('storage/' . $etablissement->photo) }}"
                                 alt="Photo"
                                 class="w-full h-64 object-cover rounded-2xl shadow-xl mb-6"/>
                            @endif

                            <!-- Nom et type -->
                            <div class="flex items-start justify-between mb-6">
                                <div>
                                    <h2 class="font-bold text-3xl text-gray-900 mb-2">
                                        {{ $etablissement->descriptetat }}
                                    </h2>
                                    <p class="text-lg text-gray-600">{{ $etablissement->nometat }}</p>
                                </div>
                                <span class="{{ $etablissement->type === 'Université Publique' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700' }} px-4 py-2 rounded-xl font-semibold text-sm">
                                    {{ $etablissement->type }}
                                </span>
                            </div>

                            <!-- Informations de contact -->
                            <div class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-2xl p-6 mb-6 border border-gray-200">
                                <h3 class="text-xl font-bold mb-4 flex items-center gap-2 text-gray-900">
                                    <i class="ri-information-line text-blue-600"></i>
                                    Informations de contact
                                </h3>
                                <div class="space-y-3">
                                    <div class="flex items-center gap-3 text-gray-700">
                                        <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                                            <i class="ri-map-pin-2-line text-red-600"></i>
                                        </div>
                                        <span>{{ $etablissement->ville ?? 'Aucune adresse fournie' }}</span>
                                    </div>
                                    
                                    @if(!$etablissement->liensite)
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                            <i class="ri-links-fill text-blue-600"></i>
                                        </div>
                                        <p class="text-blue-600 hover:text-blue-800 transition">
                                             Aucun lien fourni
                                        </p>
                                    </div>
                                    @else
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                            <i class="ri-links-fill text-blue-600"></i>
                                        </div>
                                        <a href="{{ $etablissement->liensite}}" target="_blank" 
                                           class="text-blue-600 hover:text-blue-800 transition hover:underline">
                                            Visiter le site web
                                        </a>
                                    </div>
                                    @endif
                                    
                                    <div class="flex items-center gap-3 text-gray-700">
                                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                            <i class="ri-phone-line text-green-600"></i>
                                        </div>
                                        <span>{{ $etablissement->contact ?? 'Contact non fourni'}} </span>
                                    </div>
                                    
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center flex-shrink-0">
                                            <i class="ri-mail-line text-purple-600"></i>
                                        </div>
                                        <a href="mailto:{{ $etablissement->email }}" 
                                           class="text-blue-600 hover:text-blue-800 transition hover:underline">
                                            {{ $etablissement->email }}
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Filières -->
                            <div>
                                <h3 class="text-2xl font-bold mb-4 flex items-center gap-2 text-gray-900">
                                    <i class="ri-graduation-cap-line text-blue-600"></i>
                                    Filières disponibles
                                    <span class="text-lg text-gray-500">({{ $etablissement->filieres->count() }})</span>
                                </h3>
                                
                                <div class="grid {{ $etablissement->filieres->count() > 6 ? 'md:grid-cols-2' : 'grid-cols-1' }} gap-4">
                                    @forelse ($etablissement->filieres as $filiere)
                                    <div class="bg-white border-2 border-gray-200 rounded-xl p-4 
                                        {{ $etablissement->type == 'Grande-École' ? 'hover:border-blue-200' : 'hover:border-orange-200' }}
                                             hover:shadow-lg transition">
                                            <div class="flex items-start gap-3">
                                                <i class="ri-checkbox-circle-fill text-green-500 text-2xl flex-shrink-0 mt-1"></i>
                                                <div>
                                                    <p class="font-semibold text-gray-900 mb-1">{{ $filiere->nom }}</p>
                                                    <p class="text-gray-600 text-sm">{{ $filiere->descript }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-gray-500">Aucune filière disponible</p>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Bouton fermer -->
                            <button onclick="fermer('modal-{{ $etablissement->id }}')" 
                                    class="w-full mt-6 py-4 rounded-xl bg-gradient-to-r from-gray-600 to-gray-700 text-white font-semibold hover:from-gray-700 hover:to-gray-800 transition">
                                Fermer
                            </button>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            @endif
        </div>

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