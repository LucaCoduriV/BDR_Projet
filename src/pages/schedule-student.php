<?php
/*
-----------------------------------------------------------------------------------
Nom du fichier : schedule-student.php
Auteur(s)      : Coduri Luca, Praz Tobie, Louis Hadrien
Date creation  : 20.01.2022
Description    : Ce fichier définit la page permettant d'afficher les horaires
                 d'un étudiant ou d'un professeur
Remarque(s)    : -
-----------------------------------------------------------------------------------
*/

include_once("../db.php");

$semestres = $db->semestre->getSemestres();

function pPrint($value)
{
    echo "<pre>";
    print_r($value);
    echo "</pre>";
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
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

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
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
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
                    if (isset($error) && $error[0] != "00000") {
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
                            <h6 class="m-0 font-weight-bold text-primary">Afficher l'horaire d'un étudiant</h6>
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
                                        Etudiant :
                                        <select name="idEtudiant" class="form-control" aria-label="Default select example">
                                            <option selected disabled>Choisissez un étudiant</option>
                                            <?php
                                            foreach ($db->etudiant->getEtudiants() as $etudiant) {
                                                $selected = (isset($_POST['idEtudiant']) && $etudiant['idpersonne'] == $_POST['idEtudiant']) ? " selected" : "";
                                                echo "<option" . $selected . " value='" . $etudiant['id'] . "'>" . mb_strtoupper($etudiant['nom']) . " " . $etudiant['prénom'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </label>

                                    <label>
                                        <input type="submit" class="form-control btn btn-primary" value="Valider" />
                                    </label>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Afficher l'horaire d'un professeur</h6>
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
                                        Professeur :
                                        <select name="idProfesseur" class="form-control" aria-label="Default select example">
                                            <option selected disabled>Choisissez un professeur</option>
                                            <?php
                                            foreach ($db->professeur->getProfesseurs() as $professeur) {
                                                $selected = (isset($_POST['idProfesseur']) && $professeur['idpersonne'] == $_POST['idProfesseur']) ? " selected" : "";
                                                echo "<option" . $selected . " value='" . $professeur['id'] . "'>" . mb_strtoupper($professeur['nom']) . " " . $professeur['prénom'] . "</option>";

                                            }
                                            ?>
                                        </select>
                                    </label>

                                    <label>
                                        <input type="submit" class="form-control btn btn-primary" value="Valider" />
                                    </label>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <?php if ((isset($_POST['idEtudiant']) || isset($_POST['idProfesseur'])) && isset($_POST['idSemestre'])) { ?>

                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Horaires</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Lundi</th>
                                                <th>Mardi</th>
                                                <th>Mercredi</th>
                                                <th>Jeudi</th>
                                                <th>Vendredi</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $lignes = array_fill(0, 6, 0);

                                            if(!empty($_POST['idEtudiant'])) {
                                                $horaires = $db->horaire->getHoraireEtudiant($semestres[$_POST['idSemestre']]['numéro'], $semestres[$_POST['idSemestre']]['année'], $_POST['idEtudiant']);
                                            } else if(isset($_POST['idProfesseur'])) {
                                                $horaires = $db->horaire->getHoraireProf($semestres[$_POST['idSemestre']]['numéro'], $semestres[$_POST['idSemestre']]['année'], $_POST['idProfesseur']);
                                            }

                                            //pPrint($horaires);

                                            foreach ($db->plagehoraire->getPlagesHoraire() as $plageHoraires) {
                                                foreach ($lignes as $key => $ligne) {
                                                    $lignes[$key]--;
                                                }
                                            ?>

                                                <tr>
                                                    <td><?= $plageHoraires[1] ?> <br /> <?= $plageHoraires[2] ?></td>
                                                    <?php

                                                    for ($i = 1; $i <= 5; $i++) {
                                                        $used = false;
                                                        foreach ($horaires as $horaire) {

                                                            if ($horaire['noplagehoraire'] == $plageHoraires[0] && $horaire['joursemaine'] == $i) {
                                                                echo "<td class='bg-primary text-white' rowspan='" . $horaire['nbrpériodes'] . "'>" . $horaire['nom'] . "<br/>"
                                                                    . $horaire['trigramme'] . "<br/>"
                                                                    . $horaire['nosalle'] . "</td>";
                                                                $used = true;
                                                                $lignes[$i] = $horaire['nbrpériodes'];

                                                                break;
                                                            }
                                                        }

                                                        if ($lignes[$i] < 1) {
                                                            echo "<td></td>";
                                                        }
                                                    }
                                                    ?>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
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