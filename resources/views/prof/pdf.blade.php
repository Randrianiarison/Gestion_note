<!DOCTYPE html>
<html>
<head>
    <title>Notes des Étudiants</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
<h2>Liste de note des étudiants</h2>
<p><strong>Cours:</strong> {{ $titre_cours }}</p>
<p><strong>Semestre:</strong> {{ $semestre }}</p>
<p><strong>Année scolaire:</strong> {{ $annee_scolaire }}</p>

<table>
    <thead>
    <tr>
        <th>Étudiant</th>
        <th>Somme des notes</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($etudiants as $etudiant)
        <tr>
            <td>{{ $etudiant->nom }} {{ $etudiant->prenom }}</td>
            <td>{{ $etudiant->somme_notes }} / 20</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
