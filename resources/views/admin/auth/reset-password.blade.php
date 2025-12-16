<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe - CHELSY Restaurant</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

<body class="bg-gradient-to-br from-gray-100 via-white to-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">

            <!-- Header -->
            <div class="bg-primary px-8 py-12 text-center">
                <div class="inline-block bg-white/20 rounded-full p-4 mb-4">
                    <i class="fas fa-lock text-accent text-4xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">
                    Nouveau mot de passe
                </h1>
                <p class="text-gray-200">
                    Définissez votre nouveau mot de passe
                </p>
            </div>

            <!-- Form -->
            <div class="px-8 py-8">

                @if($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-400 mr-2"></i>
                            <div>
                                <p class="text-red-700 font-bold">Erreur</p>
                                <ul class="list-disc list-inside text-red-600 mt-2 text-sm">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.password.update') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="token"
                        value="{{ $token ?? request()->route('token') ?? old('token') }}">

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-envelope text-accent mr-2"></i>
                            Adresse email
                        </label>
                        <input
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg
                                   focus:ring-2 focus:ring-accent focus:border-transparent transition-all"
                            type="email"
                            name="email"
                            value="{{ old('email', $email ?? request()->email) }}"
                            readonly
                        >
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-lock text-accent mr-2"></i>
                            Nouveau mot de passe
                        </label>
                        <input
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg
                                   focus:ring-2 focus:ring-accent focus:border-transparent transition-all"
                            type="password"
                            name="password"
                            required
                            autofocus
                            placeholder="••••••••"
                        >
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            Minimum 8 caractères
                        </p>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-lock text-accent mr-2"></i>
                            Confirmer le mot de passe
                        </label>
                        <input
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg
                                   focus:ring-2 focus:ring-accent focus:border-transparent transition-all"
                            type="password"
                            name="password_confirmation"
                            required
                            placeholder="••••••••"
                        >
                    </div>

                    <button
                        type="submit"
                        class="w-full flex items-center justify-center px-6 py-3
                               bg-primary text-white rounded-lg
                               hover:opacity-90 transition-all shadow-lg"
                    >
                        <i class="fas fa-check text-accent mr-2"></i>
                        Réinitialiser le mot de passe
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <a href="{{ route('admin.login') }}"
                       class="text-sm text-primary hover:underline">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Retour à la connexion
                    </a>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
