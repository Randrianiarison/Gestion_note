<!DOCTYPE html>
<html>
<head>
    <title>Étudiants inscrits</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Étudiants inscrits dans le cours : {{ $cours->titre }}</h1>
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
</body>
</html>
