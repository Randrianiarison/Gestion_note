<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moyennes des Étudiants</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
                    <a class="nav-link" href="{{route('prof.home')}}">Accueil <span class="sr-only">(current)</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="https://www.facebook.com/profile.php?id=100077201632825">Aide</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-5">

    @foreach ($cours as $unCours)
        <h2>{{ $unCours->titre }}</h2>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Moyenne</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($moyennes[$unCours->id]))
                @foreach ($moyennes[$unCours->id] as $etudiantMoyenne)
                    <tr>
                        <td>{{ $etudiantMoyenne['etudiant']->nom }}</td>
                        <td>{{ $etudiantMoyenne['etudiant']->prenom }}</td>
                        <td>{{ number_format($etudiantMoyenne['average'], 2) }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3">Aucune note disponible</td>
                </tr>
            @endif
            </tbody>
        </table>
    @endforeach
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
