@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Moyenne des étudiants pour le cours {{ $cours->titre }}</h1>

        <div class="card">
            <div class="card-header">
                <h5>Semestre {{ $semestre }} - Année scolaire {{ $annee_scolaire }}</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                    <tr>
                        <th>Nom de l'étudiant</th>
                        <th>Moyenne</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($etudiants as $etudiant)
                        <tr>
                            <td>{{ $etudiant->nom }} {{ $etudiant->prenom }}</td>
                            <td>
                                @if (isset($moyennes[$etudiant->id]))
                                    {{ number_format($moyennes[$etudiant->id], 2) }}
                                @else
                                    <span class="text-warning">Pas de notes disponibles</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
