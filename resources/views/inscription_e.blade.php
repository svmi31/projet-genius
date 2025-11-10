<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Formulaire | Etablissement</title>
</head>
@if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
<body class=" bg-blue-50 min-h-screen w-full flex items-center justify-center font-[Poppins]">
    <div class="bg-white shadow-lg rounded-2xl p-8 w-full  border border-gray-200">
        
    @if(session('error') || session('success'))
    <p class="text-center mb-4 font-medium py-2 rounded-lg border
        {{ session('error') ? 'text-red-600 bg-red-100 border-red-300' : 'text-green-600 bg-green-100 border-green-300' }}">
        
        {{ session('error') ?? session('success') }}
    </p>
@endif



        <button onclick="window.location='{{ route('filieres.create') }}'" 
            class="mb-4 bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 transition duration-200 float-right">
            Ajouter une filière 
        </button>

        <h1 class="text-2xl font-semibold text-center mb-6 text-blue-600">Ajouter un établissement</h1>

        <form action="{{ route('etablissement.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('post')

            <!-- sigle de l'etablissemnt -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Sigle de l’établissement</label>
                <input type="text" name="nometat" placeholder="Ex : AIBS" 
                    class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>
            <!-- nom de l'etablissement -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Nom de l'établissement</label>
                <input type="text" name="descriptetat" placeholder="Ex : Atlantique International Business School"
                    class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div> 

            <!-- photo -->
            <div class="mb-4">
    <label class="block text-gray-700 font-medium mb-2">Photo</label>

    <!-- Rectangle d’upload -->
    <label for="photoInput" 
           class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:bg-gray-100 transition">
            <i class="ri-image-add-line text-5xl text-gray-400"></i>

        <p class="mt-2 text-gray-600">Cliquez pour sélectionner une image</p>

        <!--  Champ fichier caché -->
        <input id="photoInput" type="file" name="photo" accept="image/*" class="hidden">
    </label>

</div>

            <!-- Ville -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Ville</label>
                <input type="text" name="ville" placeholder="Ex : Abidjan"
                    class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Contact -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Contact</label>
                <input type="number" name="contact" placeholder="Ex : 0102030405"
                    class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Email -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Email</label>
                <input type="email" name="email" placeholder="Ex : info@aibs.net"
                    class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" >
            </div>

            <!-- Type -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Type d’établissement</label>
                <select name="type" class="w-full border border-gray-300 rounded-lg p-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    <option value="" disabled selected>Choisissez le type</option>
                    <option value="Grande-École">Grande École</option>
                    <option value="Université Privée">Université Privée</option>
                    <option value="Université Publique">Université Publique</option>
                </select>
            </div>

            <!-- Lien de l'etablissement -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Lien de l’établissement</label>
                <input type="url" name="liensite" placeholder="Ex : https://www.aibs.net"
                    class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Filières -->
            <div>
            <label class="block text-gray-700 font-medium mb-2">Filières proposées</label>

            <!-- Liste des filières existantes -->
         <div class="grid grid-cols-2 gap-2 mb-3">
        @foreach($filieres as $filiere)
            <label class="flex items-center space-x-2 border border-gray-200 p-2 rounded-lg hover:bg-blue-50">
                <input type="checkbox" name="filieres[]" value="{{ $filiere->id }}" class="accent-blue-500">
                <span>{{ $filiere->nom }}</span>
            </label>
        @endforeach
    </div>

    <!-- Ajout d'une nouvelle filière -->
    <h2 class="mb-2 text-gray-700">Votre filière ne figure pas dans cette liste ?</h2>

    <input type="text" 
           name="nouvelle_filiere" 
           placeholder="Nom de la filière" 
           class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-400 mb-3">
</div>


            <!-- Bouton -->
            <div class="text-center">
                <button type="submit" 
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition duration-200">
                    Ajouter l’établissement 
                </button>
            </div>
        </form>
    </div>
</body>

</html>