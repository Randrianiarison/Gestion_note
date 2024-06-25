<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Gestion de Note</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <!-- Custom styles -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa; /* Couleur de fond pour le corps */
        }

        .navbar-custom {
            background-color: #4285f4; /* Couleur de fond pour la barre de navigation */
        }

        .navbar-brand {
            color: #ffffff;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .navbar-nav .nav-item .nav-link {
            color: #ffffff;
        }

        .navbar-nav .nav-item .nav-link:hover {
            color: #f8f9fa;
        }

        .container {
            padding-top: 20px;
        }

        .content {
            background-color: #ffffff;
            padding: 20px;
            margin-top: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

<!-- Navbar -->
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
                    <a class="nav-link" href="{{route('prof.home')}}">Accueil <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cours.etudiants.devoir', ['cours_id' => 2, 'etudiant_id' => 1, 'annee_scolaire' => '2024-2025', 'semestre' => 1]) }}
">Devoir</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Note</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Aide</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Recherche" aria-label="Recherche">
                <button class="btn btn-light my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
</nav>
<!-- End Navbar -->

<!-- Page Content -->
<div class="container">
    <div class="content">
        <div class="classroom-header text-center">
            <h1>{{ $cours->titre }}</h1>
        </div>
        <p class="mb-2">Semestre : {{ $semestre }}</p>
        <p class="mb-4">Année scolaire : {{ $annee_scolaire }}</p>

        @if($etudiants->isEmpty())
            <div class="alert alert-warning" role="alert">
                Aucun étudiant n'est inscrit dans ce cours pour le semestre et l'année scolaire spécifiés.
            </div>
        @else
            <ul class="list-group">
                @foreach($etudiants as $etudiant)
                    <li class="list-group-item">{{ $etudiant->nom }} {{ $etudiant->prenom }}</li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
<!-- End Page Content -->

<!-- jQuery and Bootstrap Bundle with Popper -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
