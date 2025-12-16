<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié - FOOD EXPRESS</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0A1F44',
                        accent: '#FFA500',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-200">
<section class="min-h-screen flex flex-col lg:flex-row">

    <!-- FORM -->
    <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-md bg-white rounded-xl shadow-sm p-6 sm:p-8">

            <!-- Header -->
            <div class="mb-6 text-center">
                <div class="w-12 h-12 mx-auto mb-3 flex items-center justify-center bg-primary rounded-lg">
                    <i class="fas fa-key text-accent text-xl"></i>
                </div>
                <h1 class="text-xl font-semibold text-primary">Mot de passe oublié</h1>
                <p class="text-sm text-gray-500">
                    Réinitialisation administrateur
                </p>
            </div>

            <!-- Errors -->
            @if($errors->any())
                <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-3 rounded text-sm">
                    @foreach($errors->all() as $error)
                        <p class="text-red-600">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Success -->
            @if(session('status'))
                <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-3 rounded text-sm text-green-700">
                    {{ session('status') }}
                </div>
            @endif

            <!-- FORM -->
            <form method="POST" action="{{ route('admin.password.email') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Adresse email
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        placeholder="admin@food-express.bj"
                        class="w-full p-3 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-accent"
                    >
                    <p class="text-xs text-gray-500 mt-2">
                        Un lien de réinitialisation sera envoyé à cette adresse.
                    </p>
                </div>

                <button
                    type="submit"
                    class="w-full bg-primary text-white py-3 rounded-md font-medium hover:opacity-90 transition"
                >
                    Envoyer le lien
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('admin.login') }}"
                   class="text-xs text-gray-500 hover:text-primary">
                    ← Retour à la connexion
                </a>
            </div>

        </div>
    </div>

    <!-- IMAGE -->
    <div class="hidden lg:block lg:w-1/2 relative">
        <img
            src="/images/image-food-express.png"
            alt="FOOD EXPRESS"
            class="absolute inset-0 w-full h-full object-cover"
        >
        <div class="absolute inset-0 bg-primary/70"></div>
    </div>

</section>
</body>
</html>
