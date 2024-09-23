<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport du Chauffeur</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 20px;
        }
        h1 {
            color: #000000;
            margin-bottom: 20px;
        }
        table {
            background-color: #fff;
            width: 100%;
            justify-content: center;
            align-items: center
        }
        th {
            background-color: #007bff;
            color: #fff;
        }
        td, th {
            padding: 12px;
        }
        td {
            background-color: #f2f2f2;
        }
        .table-container {
            margin-top: 30px;

        }
        .info-block {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 style="text-align: center"><i class="fas fa-user-tie"></i> Rapport du Chauffeur {{ $chauffeur->nom }}</h1>

    <div class="info-block">
        <p><strong><i class="fas fa-phone-alt"></i> Numéro de téléphone:</strong> {{ $chauffeur->telephone }}</p>
        <p><strong><i class="fas fa-map-marker-alt"></i> Adresse:</strong> {{ $chauffeur->adresse }}</p>
    </div>

    <div class="table-container">
        <h3><i class="fas fa-car"></i> Véhicule :</h3>
        <table class="table table-bordered">
            <thead class="thead-dark">
            <tr>
                <th scope="col"><i class="fas fa-car-side"></i> Marque</th>
                <th scope="col"><i class="fas fa-id-card"></i> Immatriculation</th>
                <th scope="col"><i class="fas fa-palette"></i> Couleur</th>
                <th scope="col"><i class="fas fa-list-alt"></i> Catégorie</th>
            </tr>
            </thead>
            <tbody>
            @foreach($chauffeur->vehicules as $vehicule)
                <tr>
                    <td>{{ $vehicule->marque }}</td>
                    <td>{{ $vehicule->plaqueImmat }}</td>
                    <td>{{ $vehicule->couleurVehicule }}</td>
                    <td>{{ $vehicule->categorie->nomCategorie ?? 'Aucune' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
