@extends('admin.layout')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'Gestion du Restaurant')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-store text-blue-500 mr-3"></i>
                    Informations du Restaurant
                </h1>
                <p class="text-gray-500 mt-1">Gérez les informations de votre restaurant</p>
            </div>
            <div>
                <a href="{{ route('admin.restaurant.show') }}" class="flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all shadow">
                    <i class="fas fa-eye mr-2"></i>
                    Voir le restaurant
                </a>
            </div>
        </div>

        <!-- Formulaire -->
        <form action="{{ route('admin.restaurant.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nom & Téléphone -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="name">
                        <i class="fas fa-building text-blue-500 mr-2"></i>Nom du Restaurant *
                    </label>
                    <input class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                           id="name" type="text" name="name" value="{{ old('name', $restaurant->name ?? '') }}" required>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="phone">
                        <i class="fas fa-phone text-blue-500 mr-2"></i>Téléphone
                    </label>
                    <input class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                           id="phone" type="text" name="phone" value="{{ old('phone', $restaurant->phone ?? '') }}">
                </div>
            </div>

            <!-- Email & Adresse -->
            <div>
                <label class="block text-gray-700 text-sm font-semibold mb-2" for="email">
                    <i class="fas fa-envelope text-blue-500 mr-2"></i>Email
                </label>
                <input class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                       id="email" type="email" name="email" value="{{ old('email', $restaurant->email ?? '') }}">
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-semibold mb-2" for="address">
                    <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>Adresse
                </label>
                <input class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                       id="address" type="text" name="address" value="{{ old('address', $restaurant->address ?? '') }}">
            </div>

            <!-- Description -->
            <div>
                <label class="block text-gray-700 text-sm font-semibold mb-2" for="description">
                    <i class="fas fa-align-left text-blue-500 mr-2"></i>Description
                </label>
                <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                          id="description" name="description" rows="4">{{ old('description', $restaurant->description ?? '') }}</textarea>
            </div>

            <!-- Logo -->
            <div>
                <label class="block text-gray-700 text-sm font-semibold mb-2" for="logo">
                    <i class="fas fa-image text-blue-500 mr-2"></i>Logo du Restaurant
                </label>
                @php
                    $hasLogo = $restaurant->logo && Storage::disk('public')->exists($restaurant->logo);
                    $logoUrl = $hasLogo ? Storage::url($restaurant->logo) : asset('images/default_restaurant.png');
                @endphp
                <div class="mb-4 p-4 bg-gray-50 rounded-lg border-2 {{ $hasLogo ? 'border-blue-200' : 'border-gray-200' }}">
                    <p class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
                        <i class="fas fa-image text-blue-500 mr-2"></i>
                        {{ $hasLogo ? 'Logo actuel' : 'Aucun logo actuel' }}
                    </p>
                    <img src="{{ $logoUrl }}" alt="Logo" class="max-w-xs rounded-lg shadow-md {{ $hasLogo ? '' : 'opacity-50' }}">
                    <p class="text-xs text-gray-500 mt-2 flex items-center">
                        <i class="fas fa-info-circle mr-1"></i>
                        {{ $hasLogo ? 'Si vous ne choisissez pas de nouveau logo, le logo actuel sera conservé.' : 'Le logo par défaut sera utilisé si vous n\'ajoutez pas de logo.' }}
                    </p>
                </div>
                <label for="logo" class="cursor-pointer flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <i class="fas fa-cloud-upload-alt text-3xl text-blue-500 mb-2"></i>
                        <p class="text-sm text-gray-500"><span class="font-semibold">Cliquez pour télécharger</span> ou glissez-déposez</p>
                        <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF, WEBP (MAX. 2MB)</p>
                    </div>
                    <input type="file" id="logo" name="logo" class="hidden" accept="image/*" onchange="previewImage(this, 'logoPreview')">
                </label>
                <div id="logoPreview" class="mt-4 hidden">
                    <p class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
                        <i class="fas fa-eye text-blue-500 mr-2"></i>
                        Aperçu du nouveau logo
                    </p>
                    <img id="previewLogoImg" src="" alt="Aperçu" class="max-w-xs rounded-lg shadow-md">
                </div>
            </div>

            <!-- Galerie d'images -->
            <div>
                <label class="block text-gray-700 text-sm font-semibold mb-2" for="images">
                    <i class="fas fa-images text-blue-500 mr-2"></i>Galerie d'images du Restaurant
                </label>
                <div class="mt-1 flex items-center space-x-5">
                    <label for="images" class="cursor-pointer flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <i class="fas fa-cloud-upload-alt text-3xl text-blue-500 mb-2"></i>
                            <p class="text-sm text-gray-500"><span class="font-semibold">Cliquez pour télécharger</span> ou glissez-déposez</p>
                            <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF, WEBP (MAX. 2MB) - Plusieurs images possibles</p>
                        </div>
                        <input type="file" id="images" name="images[]" class="hidden" accept="image/*" multiple onchange="previewImages(this, 'imagesPreview')">
                    </label>
                </div>
                <div id="imagesPreview" class="mt-4 hidden">
                    <p class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
                        <i class="fas fa-eye text-blue-500 mr-2"></i>
                        Aperçu des nouvelles images
                    </p>
                    <div id="imagesPreviewContainer" class="grid grid-cols-3 gap-2"></div>
                </div>
            </div>

            <!-- Paramètres livraison -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="delivery_fee_base">Frais de livraison de base (FCFA)</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" 
                           id="delivery_fee_base" type="number" step="0.01" name="delivery_fee_base" value="{{ old('delivery_fee_base', $restaurant->delivery_fee_base ?? 0) }}">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="delivery_fee_per_km">Frais par km (FCFA)</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" 
                           id="delivery_fee_per_km" type="number" step="0.01" name="delivery_fee_per_km" value="{{ old('delivery_fee_per_km', $restaurant->delivery_fee_per_km ?? 0) }}">
                </div>
            </div>

            <!-- Coordonnées géographiques -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-semibold mb-2"><i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>Coordonnées géographiques</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <input class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 cursor-not-allowed" id="latitude" type="number" step="0.00000001" name="latitude" value="{{ old('latitude', $restaurant->latitude ?? 6.372477) }}" readonly>
                    <input class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 cursor-not-allowed" id="longitude" type="number" step="0.00000001" name="longitude" value="{{ old('longitude', $restaurant->longitude ?? 2.354006) }}" readonly>
                </div>
                <div id="map" style="height: 400px; border-radius: 8px; border: 2px solid #e5e7eb;"></div>
            </div>

            <!-- Boutons -->
            <div class="flex gap-4 pt-4">
                <button type="submit" class="flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg hover:shadow-xl">
                    <i class="fas fa-save mr-2"></i>
                    Enregistrer les modifications
                </button>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all">
                    <i class="fas fa-times mr-2"></i>
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    const previewImg = document.getElementById(previewId.replace('Preview', 'Img'));
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    } else preview.classList.add('hidden');
}
function previewImages(input, previewId) {
    const preview = document.getElementById(previewId);
    const container = document.getElementById(previewId + 'Container');
    if (input.files && input.files.length > 0) {
        container.innerHTML = '';
        Array.from(input.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgDiv = document.createElement('div');
                imgDiv.className = 'relative';
                imgDiv.innerHTML = `<img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg shadow-md"><div class="absolute top-1 right-1 bg-blue-500 text-white px-2 py-1 rounded-full text-xs font-semibold">${index+1}</div>`;
                container.appendChild(imgDiv);
            };
            reader.readAsDataURL(file);
        });
        preview.classList.remove('hidden');
    } else preview.classList.add('hidden');
}

// Leaflet Map
document.addEventListener('DOMContentLoaded', function() {
    const defaultLat = {{ $restaurant->latitude ?? 6.372477 }};
    const defaultLng = {{ $restaurant->longitude ?? 2.354006 }};
    const map = L.map('map').setView([defaultLat, defaultLng], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap contributors', maxZoom: 19 }).addTo(map);
    const marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);
    function updateCoordinates(lat, lng) {
        document.getElementById('latitude').value = lat.toFixed(8);
        document.getElementById('longitude').value = lng.toFixed(8);
    }
    marker.on('dragend', function() { updateCoordinates(marker.getLatLng().lat, marker.getLatLng().lng); });
    map.on('click', function(e){ marker.setLatLng([e.latlng.lat, e.latlng.lng]); updateCoordinates(e.latlng.lat, e.latlng.lng); });
    updateCoordinates(defaultLat, defaultLng);
});
</script>
@endpush
@endsection
