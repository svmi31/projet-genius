<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire | Filière</title>
</head>
@if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
<body class="bg-gray-100 min-h-screen flex items-center justify-center font-[Poppins]">
    <div class="bg-white shadow-md rounded-2xl p-8 w-full max-w-md">

    
        @if (session('error'))
    <p class="text-red-600 text-center mb-4 font-medium bg-red-100 border border-red-300 rounded-lg py-2">
        {{ session('error') }}
    </p>
    @elseif (session('success'))
    <p class="text-green-600 text-center mb-4 font-medium bg-green-100 border border-green-300 rounded-lg py-2">
        {{ session('success') }}
    </p>
    @endif

        
        <button onclick="window.location='{{ route('etablissement.create') }}'" class="mb-4 text-blue-600 hover:underline font-medium">
            ajouter un etablissement
        </button>

        <form action="{{ route('filieres.store') }}" method="POST" class="space-y-4">
            @csrf
            @method('post')

            <div>
                <input 
                    type="text" 
                    name="nom" 
                    placeholder="Nom de la filière" 
                    required
                    class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder-gray-400"
                >
            </div>

            <div>
                <input 
                    type="text" 
                    name="descript" 
                    placeholder="Description" 
                    required
                    class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder-gray-400"
                >
            </div>

            <div class="text-center">
                <button 
                    type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition duration-200"
                >
                    Ajouter
                </button>
            </div>
        </form>
    </div>
</body>

</html>