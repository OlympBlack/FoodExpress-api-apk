<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin - CHELSY Restaurant</title>

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

<body class="bg-gray-200 h-full">
<section class="min-h-screen flex flex-col lg:flex-row">

    <!-- FORM -->
    <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-md bg-white rounded-xl shadow-sm p-6 sm:p-8">

            <!-- Header -->
            <div class="mb-6 text-center">
                <div class="w-12 h-12 mx-auto mb-3 flex items-center justify-center bg-primary rounded-lg">
                    <i class="fas fa-utensils text-accent text-xl"></i>
                </div>
                <h1 class="text-xl font-semibold text-primary">FOOD EXPRESS</h1>
                <p class="text-sm text-gray-500">Connexion administrateur</p>
            </div>

            <!-- Errors -->
            @if($errors->any())
                <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-3 rounded text-sm">
                    @foreach($errors->all() as $error)
                        <p class="text-red-600">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- FORM -->
            <form method="POST" action="{{ route('admin.login') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Email
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full p-3 border rounded-md border-black focus:outline-none focus:ring-2 focus:ring-accent"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Mot de passe
                    </label>
                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full p-3 border rounded-md border-black focus:outline-none focus:ring-2 focus:ring-accent"
                    >
                </div>

                <div class="text-right">
                    <a href="{{ route('admin.password.request') }}"
                       class="text-xs text-gray-500 hover:text-primary">
                        Mot de passe oublié ?
                    </a>
                </div>

                <button
                    type="submit"
                    class="w-full bg-primary text-white py-3 rounded-md font-medium hover:opacity-90 transition"
                >
                    Se connecter
                </button>

                <div class="mt-4 bg-gray-100 border border-gray-300 rounded-md p-3 text-xs text-gray-700">
                    <p class="font-semibold text-primary mb-1">
                        Identifiants par défaut
                    </p>
                    <p>
                        <strong>Email :</strong> admin@food-express.bj<br>
                        <strong>Mot de passe :</strong> admin123
                    </p>
                </div>

            </form>

            <p class="mt-6 text-center text-xs text-gray-400">
                Accès réservé à l’administration
            </p>
        </div>
    </div>

   <!-- IMAGE (hidden on mobile) -->
    <div class="hidden lg:block lg:w-1/2 relative">
        <img
            src="/images/image-food-express.png"
            alt="CHELSY Restaurant"
            class="absolute inset-0 w-full h-full object-cover"
        >

        <!-- Overlay -->
        <div class="absolute inset-0 bg-primary/70"></div>

    </div>


</section>
</body>
</html>
