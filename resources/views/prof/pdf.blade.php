<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Moyennes des Étudiants</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f4f4f4; }
        h1 { text-align: center; }
    </style>
</head>
<body>
<h1>Moyennes des Étudiants pour le Cours : {{ $cours->titre }}</h1>
<p>Semestre : {{ $semestre }} - Année Scolaire : {{ $annee_scolaire }}</p>
<table>
    <thead>
    <tr>
        <th>Nom de l'étudiant</th>
        <th>Moyenne (sur 20)</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($etudiants as $etudiant)
        <tr>
            <td>{{ $etudiant->nom }} {{ $etudiant->prenom }}</td>
            <td>
                @if (isset($moyennes[$etudiant->id]))
                    {{ $moyennes[$etudiant->id] }}
                @else
                    Pas de notes disponibles
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
