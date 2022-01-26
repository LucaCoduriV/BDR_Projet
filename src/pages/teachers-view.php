<?php

include_once("../db.php");

if(isset($_POST['ajouterProfesseur'])) {

    $souhaiteMacaron = !isset($_POST['souhaiteMacaron']) ? 'false' : 'true';

    $error = $db->professeur->ajouterProfesseur(
        $_POST['nom'],
        $_POST['prenom'],
        $_POST['dateNaissance'],
        $souhaiteMacaron,
        $_POST['distanceDomicile'],
        $_POST['trigramme']
    );
}

if(isset($_POST['supprimerProfesseur'])) {
    $error = $db->professeur->supprimerProfesseur($_POST['id']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SMS</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php
        include_once("../header.php");
        ?>

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

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                <?php
                if(isset($error) && $error[0] != "00000") {
                    ?>
                    <div class="card mb-4 py-3 border-left-danger">
                        <div class="card-body">
                            <?= empty($error[2]) ? "Une erreur est survenue" : $error[2] ?>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Ajouter un professeur</h6>
                    </div>
                    <div class="card-body">
                        <form method="post" action="">
                            <div id="dataTable_filter" class="dataTables_filter">
                                <label>Nom
                                    <input name="nom" type="text" class="form-control form-control-sm" placeholder="" aria-controls="dataTable">
                                </label>
                                <label>Prénom
                                    <input name="prenom" type="text" class="form-control form-control-sm" placeholder="" aria-controls="dataTable">
                                </label>
                                <label>Date naissance
                                    <input name="dateNaissance" type="date" class="form-control form-control-sm" placeholder="" aria-controls="dataTable">
                                </label>
                                <label>Trigramme
                                    <input name="trigramme" type="text" size="3" maxlength="3" class="form-control form-control-sm" placeholder="" aria-controls="dataTable">
                                </label>
                                <label>Souhaite macaron
                                    <input name="souhaiteMacaron" type="checkbox" class="" placeholder="" aria-controls="dataTable">
                                </label>
                                <label>Distance domicile
                                    <input name="distanceDomicile" type="number" class="form-control form-control-sm" placeholder="" aria-controls="dataTable">
                                </label>
                                <label>
                                    <input type="submit" name="ajouterProfesseur" class="form-control btn btn-primary" value="Ajouter"/>
                                </label>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                   <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Liste des professeurs</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Date Naissance</th>
                                        <th>Trigramme</th>
                                        <th>Souhaite macaron</th>
                                        <th>Distance domicile [Km]</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($db->professeur->getProfesseurs() as $prof) {
                                        $date = date_create($prof['datenaissance']);
                                        ?>
                                        <tr>
                                            <td><?= $prof['id']; ?></td>
                                            <td><?= $prof['nom']; ?></td>
                                            <td><?= $prof['prénom']; ?></td>
                                            <td><?= date_format($date, 'd.m.Y'); ?></td>
                                            <td><?= $prof['trigramme']; ?></td>
                                            <td><?= $prof['souhaitemacaron'] ? 'oui' : 'non'; ?></td>
                                            <td><?= $prof['distancedomicilekm']; ?></td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="hidden" name="id" value="<?= $prof['id'] ?>">
                                                    <input type="submit" name="supprimerProfesseur" class="form-control btn btn-danger" value="Supprimer"/>
                                                </form>
                                                <form action="teachers-edit.php" method="GET">
                                                    <input type="hidden" name="idProfesseur" value="<?= $prof['id'] ?>">
                                                    <input type="submit" class="form-control btn btn-warning" value="Modifier"/>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php

                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

</body>

</html>