<!DOCTYPE html>
<html lang="zxx" class="no-js">
<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/fav.png">
    <!-- Author Meta -->
    <meta name="author" content="colorlib">
    <!-- Meta Description -->
    <meta name="description" content="">
    <!-- Meta Keyword -->
    <meta name="keywords" content="">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title>Taxi</title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
    <!--
    CSS
    ============================================= -->
    <link rel="stylesheet" href="{{asset('css/linearicons.css')}}">
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('css/nice-select.css')}}">
    <link rel="stylesheet" href="{{asset('css/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <!-- Include this in your head section -->

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>

    <!-- Leaflet Routing Machine CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet-routing-machine/3.2.12/leaflet-routing-machine.css" />

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>

    <!-- Leaflet Routing Machine JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-routing-machine/3.2.12/leaflet-routing-machine.min.js"></script>

    <style>
        /* CSS pour le header */
        header {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000; /* Assurez-vous que le header est au-dessus de la carte */
            background-color: white; /* Couleur d'arrière-plan du header */
        }

        /* Ajustez la marge supérieure pour éviter que le contenu ne passe sous le header */
        body {
            padding-top: 70px; /* Ajustez en fonction de la hauteur de votre header */
        }

        /* Styles de la carte */
        #map {
            height: 400px;
            z-index: 0; /* La carte se trouve derrière le header */
        }

        #controls {
            margin: 10px 0;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 5px;
        }

        #controls label {
            margin-right: 10px;
        }

        #controls input,
        #controls button {
            margin-bottom: 10px;
            padding: 5px;
            font-size: 16px;
        }

        #controls button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #controls button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
@include('partials.header')
<!-- start banner Area -->

<!-- End banner Area -->
<section style="margin: 40px auto; width: 90%">

    <div id="map" style="width: 100%; height: 400px; margin: 0 auto;"></div>

    <script>
        // Initialiser la carte centrée sur Lubumbashi
        const map = L.map('map').setView([-11.6647, 27.4794], 13);

        // Ajouter les tuiles de la carte OpenStreetMap
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Fonction pour géocoder une adresse avec Nominatim
        const API_KEY = '4948b4ccd6a84509857ce4712d71329a'; // Votre clé API OpenCage

        function geocodeAddress(address, callback) {
            fetch(`https://api.opencagedata.com/geocode/v1/json?q=${encodeURIComponent(address)}, Lubumbashi&key=${API_KEY}&language=fr`)
                .then(response => response.json())
                .then(data => {
                    if (data.results.length > 0) {
                        const { lat, lng } = data.results[0].geometry;
                        callback([parseFloat(lat), parseFloat(lng)]);
                    } else {
                        alert("Adresse non trouvée : " + address);
                    }
                })
                .catch(err => {
                    alert("Erreur de géocodage : " + err);
                });
        }




        // Fonction pour afficher l'itinéraire sur la carte avec des points de cheminement
        function showRoute(startCoords, endCoords, startAddress, endAddress) {
            // Supprimer l'itinéraire précédent s'il existe
            if (window.routeControl) {
                map.removeControl(window.routeControl);
                window.routeControl = null;
            }

            // Ajouter des marqueurs pour le point de départ et la destination
            const startMarker = L.marker(startCoords).addTo(map)
                .bindPopup('Point de départ: ' + startAddress)
                .openPopup();

            const endMarker = L.marker(endCoords).addTo(map)
                .bindPopup('Destination: ' + endAddress);

            // Calculer le centre de la carte comme le point moyen entre le départ et la destination
            const centerLat = (startCoords[0] + endCoords[0]) / 2;
            const centerLng = (startCoords[1] + endCoords[1]) / 2;

            map.setView([centerLat, centerLng], 13); // Réajuster le centre de la carte pour voir les deux points

            // Créer un itinéraire avec les points de cheminement
            window.routeControl = L.Routing.control({
                waypoints: [
                    L.latLng(startCoords[0], startCoords[1]),
                    L.latLng(endCoords[0], endCoords[1])
                ],
                routeWhileDragging: true,
                router: L.routing.osrmv1({
                    serviceUrl: 'https://router.project-osrm.org/route/v1'
                }),
                createMarker: function() { return null; } // Ne pas créer de marqueurs automatiques pour les points de cheminement
            }).addTo(map);
        }


        // Gestion du clic sur le bouton "Afficher l'itinéraire"
        document.getElementById('routeButton').addEventListener('click', function () {
            const start = document.getElementById('start').value;
            const end = document.getElementById('end').value;

            if (start && end) {
                // Géocoder le point de départ
                geocodeAddress(start, function(startCoords) {
                    // Puis géocoder la destination
                    geocodeAddress(end, function(endCoords) {
                        // Afficher l'itinéraire une fois les deux adresses géocodées
                        showRoute(startCoords, endCoords, start, end);
                    });
                });
            } else {
                alert("Veuillez entrer des noms d'avenues pour les deux points.");
            }
        });
    </script>
</section>

<!-- start footer Area -->
@include('partials.footer')

<!-- End footer Area -->
<script src="{{ asset('js/vendor/jquery-2.2.4.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="{{ asset('js/vendor/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/easing.min.js') }}"></script>
<script src="{{ asset('js/hoverIntent.js') }}"></script>
<script src="{{ asset('js/superfish.min.js') }}"></script>
<script src="{{ asset('js/jquery.ajaxchimp.min.js') }}"></script>
<script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('js/mail-script.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>

</body>
</html>
