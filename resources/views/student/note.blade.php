<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> {{ $etudiant->nom }} {{ $etudiant->prenom }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;szxc
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #dee2e6;
        }
        th {
            background-color: #007bff;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        tr:hover {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="#">Gestion de Note</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('cours.home')}}">Accueil <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('etudiant')}}">Etudiants</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Aide</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<div class="container mt-5">
    <a class="btn btn-primary btn-sm" href="{{ route('etudiants.moyenne', ['idEtudiant' => $etudiant->id]) }}">Télecharger PDF</a>
    <h1> {{ $etudiant->nom }} {{ $etudiant->prenom }} </h1>

    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Cours</th>
            <th scope="col">Moyenne des notes</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($moyennes as $moyenne)
            <tr>
                <td>{{ $moyenne['cours']->titre }}</td>
                <td>{{ number_format($moyenne['average'], 2) }}</td>
            </tr>
        @endforeach
{{--        <div class="card mt-4">--}}
{{--            <div class="card-body">--}}
{{--                <h5 class="card-title">Moyenne générale</h5>--}}
{{--                <p class="card-text">{{ $averageGeneral }}</p>--}}
{{--            </div>--}}
{{--        </div>--}}
        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
