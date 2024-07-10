<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $etudiant->nom }} {{ $etudiant->prenom }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
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
<div class="container mt-5">
    <h1>{{ $etudiant->nom }} {{ $etudiant->prenom }}</h1>

    <table>
        <thead>
        <tr>
            <th>Cours</th>
            <th>Moyenne des notes</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($moyennes as $moyenne)
            <tr>
                <td>{{ $moyenne['cours']->titre }}</td>
                <td>{{ number_format($moyenne['average'], 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
