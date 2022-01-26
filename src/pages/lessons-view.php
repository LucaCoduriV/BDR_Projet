<?php

include_once("../db.php");

if(isset($_POST['ajouterLecon'])) {

    $salle = trim(explode("-", $_POST['nomSalle'])[0]);
    $batiment = trim(explode("-", $_POST['nomSalle'])[1]);

    $error = $db->lecon->ajouterLecon(
        $_POST['idCours'],
        $_POST['idProfesseur'],
        $_POST['noPlageHoraire'],
        $_POST['typeLecon'],
        $salle,
        $batiment,
        $_POST['nbrperiodes'],
        $_POST['joursemaine']
    );
}

if(isset($_POST['supprimerLecon'])) {
    $error = $db->lecon->supprimerLecon($_POST['numero'], $_POST['idcours']);
}

$weekday = [
    1 => 'Lundi',
    2 => 'Mardi',
    3 => 'Mercredi',
    4 => 'Jeudi',
    5 => 'Vendredi'
];

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
                        <h6 class="m-0 font-weight-bold text-primary">Ajouter une leçon</h6>
                    </div>
                    <div class="card-body">
                        <form method="post" action="">
                            <div id="dataTable_filter" class="dataTables_filter">
                                <label>Cours
                                    <select name="idCours" class="form-control">
                                    <?php
                                    foreach($db->cours->getAllCours() as $cours) {
                                        ?>
                                            <option value="<?= $cours['id']?>"><?= $cours['nom'] . " - " . $cours['nosemestre'] . "/" . $cours['annéesemestre'] ?></option>
                                            <?php
                                    }
                                    ?>
                                    </select>
                                </label>
                                <label>Professeur
                                    <select name="idProfesseur" class="form-control">
                                    <?php
                                    foreach($db->professeur->getProfesseurs() as $prof) {
                                        ?>
                                        <option value="<?= $prof['id']?>"><?= mb_strtoupper($prof['nom']) . " " . $prof['prénom'] ?></option>
                                        <?php
                                    }
                                    ?>
                                    </select>
                                </label>
                                <label>Heure de début
                                    <select name="noPlageHoraire" class="form-control">
                                    <?php
                                    foreach($db->plagehoraire->getPlagesHoraire() as $plage) {
                                        $heure = date_create($plage['heuredébut']);
                                        ?>
                                        <option value="<?= $plage['numéro']?> "><?= date_format($heure, "H:i") ?></option>
                                        <?php
                                    }
                                    ?>
                                    </select>
                                </label>
                                <label>Type leçon
                                    <select name="typeLecon" class="form-control">
                                    <?php
                                    foreach($db->typelecon->getAllTypeLecon() as $type) {
                                        ?>
                                        <option value="<?=$type['libellé']?>"><?= $type['libellé'] ?></option>
                                        <?php
                                    }
                                    ?>
                                    </select>
                                </label>
                                <label>Salle
                                    <select name="nomSalle" class="form-control">
                                    <?php
                                    foreach($db->salle->getSalles() as $salle) {
                                        ?>
                                        <option value="<?= $salle['numéro'] . " - " . $salle["nombâtiment"] ?> ">Salle <?= $salle['numéro'] . " - " . $salle["nombâtiment"] ?></option>
                                        <?php
                                    }
                                    ?>
                                    </select>
                                </label>
                                <label>Nombre de périodes
                                    <select name="nbrperiodes" class="form-control">
                                    <?php
                                    for($i = 1; $i < count($db->plagehoraire->getPlagesHoraire()); ++$i) {
                                        ?>
                                        <option value="<?= $i?>"><?= $i ?></option>
                                        <?php
                                    }
                                    ?>
                                    </select>
                                </label>
                                <label>Jour semaine
                                    <select name="joursemaine" class="form-control">
                                        <?php
                                        foreach($weekday as $key => $day) {
                                            ?>
                                            <option value="<?= $key ?>"><?= $day ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </label>
                                <label>
                                    <input type="submit" name="ajouterLecon" class="form-control btn btn-primary" value="Ajouter"/>
                                </label>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                   <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Liste des leçons</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Cours</th>
                                        <th>Professeur</th>
                                        <th>Plage horaire</th>
                                        <th>Type leçon</th>
                                        <th>Salle</th>
                                        <th>Bâtiment</th>
                                        <th>Jour semaine</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($db->lecon->getLecons() as $lecon) {
                                        $heuredebut = date_create($lecon['heuredébut']);
                                        $heurefin = date_create($lecon['heurefin']);
                                        ?>
                                        <tr>
                                            <td><?= $lecon['nomcours']; ?></td>
                                            <td><?= mb_strtoupper($lecon['nomprof']) . " " . $lecon['prenomprof']; ?></td>
                                            <td><?= date_format($heuredebut, 'H:i') . " - " . date_format($heurefin, 'H:i'); ?></td>
                                            <td><?= $lecon['typelecon']?></td>
                                            <td><?= $lecon['nosalle'] ?></td>
                                            <td><?= $lecon['nomsalle']; ?></td>
                                            <td><?= $weekday[$lecon['joursemaine']] ?></td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="hidden" name="numero" value="<?= $lecon['numéro'] ?>">
                                                    <input type="hidden" name="idcours" value="<?= $lecon['idcours'] ?>">
                                                    <input type="submit" name="supprimerLecon" class="form-control btn btn-danger" value="Supprimer"/>
                                                </form>
                                                <form action="lessons-edit.php" method="GET">
                                                    <input type="hidden" name="idlecon" value="<?= $lecon['numéro'] ?>">
                                                    <input type="hidden" name="idcours" value="<?= $lecon['idcours'] ?>">
                                                    <input type="submit" class="form-control btn btn-warning" value="Modifier"/>
                                                </form>
                                                <form action="lessons-add-students.php" method="GET">
                                                    <input type="hidden" name="idlecon" value="<?= $lecon['numéro'] ?>">
                                                    <input type="hidden" name="idcours" value="<?= $lecon['idcours'] ?>">
                                                    <input type="submit" class="form-control btn btn-info" value="Ajouter étudiants"/>
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