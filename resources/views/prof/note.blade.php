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
                    <a class="nav-link" href="#">Note</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://mail.google.com/mail/u/0/#sent?compose=new" target="_blank">Email</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://www.facebook.com/profile.php?id=100077201632825" target="_blank">Aide</a>
                </li>

            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->

<!-- Page Content -->
<div class="container">
    <div class="row mt-4">
    </div>

    <div class="row">
        <div class="col-md-12">
            <p><strong>Cours ID:</strong> {{ $titre_cours }}</p>
            <p><strong>Semestre:</strong> {{ $semestre }}</p>
            <p><strong>Année scolaire:</strong> {{ $annee_scolaire }}</p>
        </div>
    </div>


    <div class="row mt-4">
        <div class="col-md-12 d-flex justify-content-end mb-3">
            <a href="{{ url('/notes/pdf/' . $cours_id . '/' . $semestre . '/' . $annee_scolaire) }}" class="btn btn-primary">Télécharger PDF</a>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <table class="table table-bordered">
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
        </div>
    </div>
</div>
<!-- End Page Content -->



<!-- jQuery and Bootstrap Bundle with Popper -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



</body>

</html>
