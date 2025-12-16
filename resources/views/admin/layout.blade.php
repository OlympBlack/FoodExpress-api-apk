<!DOCTYPE html>
<html lang="fr">
@php
use Illuminate\Support\Facades\Storage;
@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - CHELSY Restaurant')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.svg') }}">
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

    @stack('styles')
    @vite(['resources/js/app.js'])
    <style>
        .sidebar {
            transition: all 0.3s ease;
        }
        .sidebar-hidden {
            transform: translateX(-100%);
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar fixed inset-y-0 left-0 z-50 w-64 bg-primary text-white transform transition-transform duration-300 ease-in-out">
        <div class="flex items-center justify-between h-16 px-6 border-b border-accent">
            <h1 class="text-xl font-bold flex items-center">
                <i class="fas fa-utensils mr-2"></i>
                CHELSY Admin
            </h1>
            <button id="sidebarToggle" class="lg:hidden text-white hover:text-primary">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <nav class="mt-6">
            @php
            $menuItems = [
                ['route'=>'admin.dashboard','icon'=>'fa-chart-line','label'=>'Dashboard'],
                ['route'=>'admin.restaurant','icon'=>'fa-store','label'=>'Restaurant'],
                ['route'=>'admin.categories','icon'=>'fa-tags','label'=>'Catégories'],
                ['route'=>'admin.dishes','icon'=>'fa-hamburger','label'=>'Plats'],
                ['route'=>'admin.orders','icon'=>'fa-shopping-cart','label'=>'Commandes'],
                ['route'=>'admin.reviews','icon'=>'fa-star','label'=>'Avis'],
                ['route'=>'admin.complaints','icon'=>'fa-exclamation-triangle','label'=>'Réclamations'],
                ['route'=>'admin.promo-codes','icon'=>'fa-ticket-alt','label'=>'Codes Promo'],
                ['route'=>'admin.banners','icon'=>'fa-image','label'=>'Bannières'],
                ['route'=>'admin.faqs','icon'=>'fa-question-circle','label'=>'FAQ'],
                ['route'=>'admin.users','icon'=>'fa-users','label'=>'Utilisateurs'],
                ['route'=>'admin.profile','icon'=>'fa-user-circle','label'=>'Mon Profil'],
            ];
            @endphp

            @foreach($menuItems as $item)
            <a href="{{ route($item['route']) }}" 
               class="flex items-center px-6 py-3 text-white bg-primary hover:bg-accent hover:text-primary transition-colors
               {{ request()->routeIs($item['route'].'*') ? 'bg-accent text-primary border-r-4 border-yellow-400' : '' }}">
                <i class="fas {{ $item['icon'] }} w-5 mr-3"></i>
                {{ $item['label'] }}
            </a>
            @endforeach
        </nav>
        <div class="absolute bottom-0 w-full p-6 border-t border-accent">
            <button id="logoutBtn" class="flex items-center w-full px-4 py-2 text-white hover:text-primary hover:bg-accent rounded transition-colors">
                <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                Déconnexion
            </button>
            <form id="logoutForm" action="{{ route('admin.logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="lg:ml-64">
        <!-- Top Bar -->
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="flex items-center justify-between h-16 px-6 w-full">
                <button id="mobileSidebarToggle" class="lg:hidden text-gray-600 hover:text-gray-900">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                @php
                    $user = auth()->user();
                    $avatarUrl = $user->avatar ? Storage::url($user->avatar) : null;
                @endphp
                <a href="{{ route('admin.profile') }}" class="flex items-center space-x-3 hover:opacity-80 transition-opacity ml-auto flex-row-reverse">
                    @if($avatarUrl)
                        <img src="{{ $avatarUrl }}" alt="{{ $user->firstname }} {{ $user->lastname }}" class="w-10 h-10 rounded-full object-cover border-2 border-accent ml-3">
                    @else
                        <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center border-2 border-accent ml-3">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                    @endif
                    <span class="text-gray-700 font-semibold">
                        {{ $user->firstname }} {{ $user->lastname }}
                    </span>
                </a>
            </div>
        </header>

        <!-- Content -->
        <main class="p-6">
            @if($errors->any())
                <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4 rounded">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-400 mr-2"></i>
                        <div>
                            <p class="text-red-700 font-bold">Erreurs de validation :</p>
                            <ul class="list-disc list-inside text-red-600 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        // Sidebar toggle
        document.getElementById('mobileSidebarToggle')?.addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('sidebar-hidden');
        });
        document.getElementById('sidebarToggle')?.addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('sidebar-hidden');
        });

        // SweetAlert pour la déconnexion
        document.getElementById('logoutBtn')?.addEventListener('click', function() {
            Swal.fire({
                title: 'Déconnexion',
                text: 'Êtes-vous sûr de vouloir vous déconnecter ?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, me déconnecter',
                cancelButtonText: 'Annuler',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        });

        // SweetAlert for delete confirmations
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-form').forEach(form => {
                if (form.hasAttribute('onsubmit')) {
                    form.removeAttribute('onsubmit');
                }
                
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    
                    const formElement = this;
                    const button = formElement.querySelector('button[type="submit"]');
                    
                    Swal.fire({
                        title: 'Êtes-vous sûr ?',
                        text: "Cette action est irréversible !",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Oui, supprimer !',
                        cancelButtonText: 'Annuler',
                        reverseButtons: true,
                        buttonsStyling: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (button) {
                                button.disabled = true;
                                button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Suppression...';
                            }
                            formElement.submit();
                        }
                    });
                    
                    return false;
                }, true);
            });
        });
    </script>

    @if (session('success') || session('error') || session('info') || session('warning'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                toastr.success("{{ session('success') }}");
            @endif

            @if (session('error'))
                toastr.error("{{ session('error') }}");
            @endif

            @if (session('info'))
                toastr.info("{{ session('info') }}");
            @endif

            @if (session('warning'))
                toastr.warning("{{ session('warning') }}");
            @endif
        });
    </script>
    @endif

    @stack('scripts')
</body>
</html>
