<?php
/*
-----------------------------------------------------------------------------------
Nom du fichier : semestre-view.php
Auteur(s)      : Coduri Luca, Praz Tobie, Louis Hadrien
Date creation  : 20.01.2022
Description    : Ce fichier définit la page permettant de créer et de visualiser des semestres
Remarque(s)    : -
-----------------------------------------------------------------------------------
*/

include_once("../db.php");

$semestres = $db->semestre->getSemestres();

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

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Statistiques</h1>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Statistiques semestrielles</h6>
                        </div>
                        <div class="card-body">
                            <form method="post" action="">
                                <div id="dataTable_filter" class="dataTables_filter">
                                    <label>
                                        Semestre :
                                        <select name="idSemestre" class="form-control" aria-label="Default select example">
                                            <?php
                                            foreach ($semestres as $key => $semestre) {
                                                $selected = $key == $_POST['idSemestre'] ? " selected" : "";
                                                echo "<option" . $selected . " value='" . $key . "'>" . $semestre['numéro'] . " " . $semestre['année'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </label>

                                    <label>
                                        <input type="submit" class="form-control btn btn-primary" value="Valider" />
                                    </label>
                                </div>
                            </form>

                            <?php
                            if(isset($_POST['idSemestre'])) {
                                $noSemestre = $semestres[$_POST['idSemestre']]['numéro'];
                                $anneeSemestre = $semestres[$_POST['idSemestre']]['année'];
                                ?>
                                <div class="card">
                                    <div class="card-body">
                                        <div>Nombres moyen de cours suivis par élèves: <?= round(floatval($db->getNombreMoyenCoursSuivi($noSemestre, $anneeSemestre)),2) ?></div>
                                        <div>Nombres moyen de leçon suivies par les élèves par semaine: <?= round(floatval($db->getNombreLeconMoyenPourEtudiants($noSemestre, $anneeSemestre)), 2) ?></div>
                                        <div>Nombres moyen de leçon données par les professeurs par semaine: <?= round(floatval($db->getNombreLeconMoyenPourProfesseurs($noSemestre, $anneeSemestre)), 2) ?></div>
                                        <div>Taux d'élèves asynchrones: <?= round(floatval($db->getTauxEleveAsync($noSemestre, $anneeSemestre)) * 100, 2) ?>%</div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Statistiques des départs</h6>
                        </div>
                        <div class="card-body">
                            <div class="card">
                                <div class="card-body">
                                    <?php
                                    foreach ($db->statut->getAllStatut() as $key => $status) {
                                        if($status["libellé"] != "En cours") {
                                            ?>
                                            <div>Taux "<?= $status["libellé"] ?>": <?php
                                                $taux = $db->getTauxElevesParStatus($status["libellé"]);
                                                if(!is_null($taux)) {
                                                    echo round($taux * 100, 2) . "%";
                                                } else {
                                                    echo "N/A";
                                                }
                                                ?></div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->
            </div>
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