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
         .card-header {
             background-color: #007bff;
             color: #fff;
             font-size: 1.25rem;
         }
        .list-group-item {
            border: 1px solid #ddd;
            border-radius: 0.25rem;
            margin-bottom: 5px;
            padding: 10px;
            font-size: 0.875rem;
        }
        .container {
            padding: 20px;        }
        .card {
            margin-bottom: 15px;
        }
        .card-body {
            font-size: 0.875rem;
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
                    <a href="{{ route('notes.moyennes', ['id' => $cours->id, 'semestre' => $semestre, 'annee_scolaire' => $annee_scolaire]) }}" class="nav-link">
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
    <!-- Affichage des messages de succès -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Affichage des messages d'erreur -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Erreur!</strong> Veuillez vérifier les champs suivants.
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="mb-2">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Ajouter devoir
        </button>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCategoryModal">
            Ajouter une Catégorie
        </button>
    </div>

    <!-- Détails du Cours et Types de Devoirs -->
    <div class="mt-4">
        <div class="row">
            <!-- Détails du Cours -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2>Détails du Cours</h2>
                    </div>
                    <div class="card-body">
                        <p><strong>Titre du cours:</strong> {{ $cours->titre }}</p>
                        <p><strong>Semestre:</strong> {{ $semestre }}</p>
                        <p><strong>Année scolaire:</strong> {{ $annee_scolaire }}</p>
                    </div>
                </div>
            </div>

            <!-- Types de Devoirs et Pourcentages -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Types de Devoirs et Pourcentages</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($categories as $category)
                                <li class="list-group-item">
                                    <strong>{{ $category->type_devoir }}:</strong>
                                    {{ number_format($category->pourcentage, 0) }}%
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm float-right" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');">Supprimer</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                        <hr>
                        <li class="list-group-item">
                            <strong>Total des Pourcentages:</strong> {{ number_format($total, 0) }}%
                        </li>
                    </div>
                </div>
            </div>
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
                        <label for="type_devoir_id">Type de Devoir</label>
                        <select class="form-control" id="type_devoir_id" name="type_devoir_id" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->type_devoir }}</option>
                            @endforeach
                        </select>
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






<!-- Modal pour Ajouter une Catégorie -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Ajouter une Catégorie</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addCategoryForm" method="POST" action="{{route('categories.store')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="type_devoir">Type de Devoir</label>
                        <input type="text" class="form-control" id="type_devoir" name="type_devoir" required>
                    </div>
                    <div class="form-group">
                        <label for="pourcentage">Pourcentage</label>
                        <input type="number" class="form-control" id="pourcentage" name="pourcentage" min="0" max="100" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <input type="hidden" id="id_cours" name="id_cours" value="{{ $cours->id }}"">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
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
