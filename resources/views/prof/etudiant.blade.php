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

                </li>
                <li class="nav-item">
                    <a href="{{ route('cours.somme_notes', ['cours_id' => $cours->id, 'semestre' => $semestre, 'annee_scolaire' => $annee_scolaire]) }}" class="nav-link">
                         Notes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://www.facebook.com/profile.php?id=100077201632825">Aide</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->

<!-- Page Content -->
<div class="container">
    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModal">
        Ajouter
    </button>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Détails du cours</h2>
                <p><strong>Titre du cours:</strong> {{ $cours->titre }}</p>
                <p><strong>Semestre:</strong> {{ $semestre }}</p>
                <p><strong>Année scolaire:</strong> {{ $annee_scolaire }}</p>

            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <h2>Liste des devoirs</h2>
                @if ($devoirs->isEmpty())
                    <p>Aucun devoir trouvé pour ce cours, semestre et année scolaire.</p>
                @else
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Étudiants</th>
                            @foreach ($devoirs as $devoir)
                                <th>{{ $devoir->titre }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($cours->etudiants as $etudiant)
                            <tr>
                                <td>{{ $etudiant->nom }} {{ $etudiant->prenom }}</td>
                                @foreach ($devoirs as $devoir)
                                    <td>
                                        @php
                                            $note = $devoir->notes->firstWhere('id_etudiant', $etudiant->id);
                                        @endphp
                                        <input type="number" class="form-control form-control-sm mt-1" min="0" max="20" style="width: 100px;" value="{{ $note ? $note->note : '' }}" data-etudiant="{{ $etudiant->id }}" data-devoir="{{ $devoir->id }}">
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>





</div>
<!-- End Page Content -->







<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter un Devoir</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('devoir.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_cours" value="{{ $cours->id }}">
                    <input type="hidden" name="semestre" value="{{ $semestre }}">
                    <input type="hidden" name="annee_scolaire" value="{{ $annee_scolaire }}">

                    <div class="form-group">
                        <label for="titre">Titre</label>
                        <input type="text" class="form-control" id="titre" name="titre" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- jQuery and Bootstrap Bundle with Popper -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var inputs = document.querySelectorAll('input[type="number"]');

        inputs.forEach(function (input) {
            input.addEventListener('change', function () {
                var etudiantId = this.dataset.etudiant;
                var devoirId = this.dataset.devoir;
                var note = this.value;

                axios.post('/notes', {
                    id_etudiant: etudiantId,
                    id_devoir: devoirId,
                    note: note
                })
                    .then(function (response) {
                        console.log(response.data);
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            });
        });
    });
</script>








</body>

</html>
