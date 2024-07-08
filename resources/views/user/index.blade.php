<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gestion de Note</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">UAZ</div>
        </a>


        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="#">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Personne
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-user"></i>
                <span>Personne</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">AUZ:</h6>
                    <a class="collapse-item" href="">Professeur</a>
                    <a class="collapse-item" href="{{ route('etudiant') }}">Etudiant</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-book"></i>
                <span>Cours</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">UAZ:</h6>
                    <a class="collapse-item" href="{{ route('cours.home') }}">Liste</a>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-folder"></i>
                <span>Note</span>
            </a>
            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">UAZ:</h6>
                    <a class="collapse-item" href="login.html">Liste</a>
                </div>
            </div>
        </li>
        <!-- Sidebar Message -->
        <div class="sidebar-card d-none d-lg-flex">
            <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
            <p class="text-center mb-2"><strong>UAZ</strong> Gestion de note</p>
            <a class="btn btn-success btn-sm" href="">Parametre</a>
        </div>
    </ul>
    <!-- End of Sidebar -->



    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Search -->
                <form
                    class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                               aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <ul class="navbar-nav ml-auto">

                    <div class="topbar-divider d-none d-sm-block"></div>

                    {{-- deconecter --}}
                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </a>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->

            <div class="container-fluid mr-2">
                <button type="button" class="btn btn-outline-primary mr-5" data-toggle="modal" data-target="#modal-id"
                        onclick="setModalAdd()">
                    Ajouter
                </button>
            </div>
            <div class="row mt-2 ml-2">
                @foreach($users as $user)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-text text-center text-primary">
                                    @if($user->role_id == 1)
                                        Administrateur
                                    @elseif($user->role_id == 2)
                                        Professeur
                                    @else
                                        Inconnu
                                    @endif
                                </h2>
                                <h5 class="card-title">{{ $user->name }}</h5>
                                <p class="card-text">{{ $user->email }}</p>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-id"
                                        onclick="setModalEdit({{ $user }})">
                                    Modifier
                                </button>
                                <form action="{{ route('user.delete', $user->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
{{--                    <span>Gestion de note &copy; Randrianiarison Johnson</span>--}}
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->











<!-- Modal pour Ajouter/Modifier  -->
<div class="modal fade" id="modal-id" tabindex="-1" aria-hidden="true" aria-labelledby="modal-title">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Ajouter Utilisateur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('user.store') }}" id="userForm">
                    @csrf
                    <input type="hidden" id="form-method" name="_method" value="POST">
                    <input type="hidden" id="user-id" name="id">

                    <div class="mb-3">
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="role">Rôle</label>
                        <select class="form-control" id="role" name="role_id" required>
                            <option value="1">Admin</option>
                            <option value="2">Prof</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary" id="btn-save">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>





<script>
    function setModalAdd() {
        document.getElementById('modal-title').textContent = 'Ajouter Utilisateur';
        document.getElementById('userForm').action = '{{ route('user.store') }}';
        document.getElementById('form-method').value = 'POST';
        document.getElementById('user-id').value = '';
        document.getElementById('name').value = '';
        document.getElementById('email').value = '';
        document.getElementById('password').value = '';
        document.getElementById('password_confirmation').value = '';
        document.getElementById('btn-save').textContent = 'Ajouter';
    }

    function setModalEdit(user) {
        document.getElementById('modal-title').textContent = 'Modifier Utilisateur';
        document.getElementById('userForm').action = '{{ url("/user.update") }}/' + user.id;
        document.getElementById('form-method').value = 'PUT';
        document.getElementById('user-id').value = user.id;
        document.getElementById('name').value = user.name;
        document.getElementById('email').value = user.email;
        document.getElementById('password').value = '';
        document.getElementById('password_confirmation').value = '';
        document.getElementById('btn-save').textContent = 'Mettre à jour';
    }
</script>



</body>

</html>
