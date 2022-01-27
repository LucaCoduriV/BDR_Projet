<?php
/*
-----------------------------------------------------------------------------------
Nom du fichier : notes-view.php
Auteur(s)      : Coduri Luca, Praz Tobie, Louis Hadrien
Date creation  : 20.01.2022
Description    : Ce fichier définit la page permettant de créer et de visualiser des notes
Remarque(s)    : -
-----------------------------------------------------------------------------------
*/

include_once("../db.php");

function pPrint($value)
{
    echo "<pre>";
    print_r($value);
    echo "</pre>";
}

if (isset($_POST['idtest']) && isset($_POST['note'])) {
    $db->insertNote($_POST['idEtudiant'], $_POST['idtest'], $_POST['note']);
}

if (isset($_POST['idEtudiant'])) {
    $notes = $db->getNotesEleve($_POST['idEtudiant']);
    //pPrint($notes);
    $cours = $db->cours->getCoursEtudiant($_POST['idEtudiant']);
    $tests = $db->getAllTestsEtudianCanHave($_POST['idEtudiant']);
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
                            <h6 class="m-0 font-weight-bold text-primary">Afficher les notes d'un étudiant</h6>
                        </div>
                        <div class="card-body">
                            <form method="post" action="">
                                <div id="dataTable_filter" class="dataTables_filter">

                                    <label>
                                        Etudiant :
                                        <select name="idEtudiant" class="form-control" aria-label="Default select example">
                                            <option selected>Choisissez un étudiant</option>
                                            <?php
                                            foreach ($db->etudiant->getEtudiants() as $etudiant) {
                                                $selected = $etudiant['id'] == $_POST['idEtudiant'] ? " selected" : "";
                                                echo "<option" . $selected . " value='" . $etudiant['id'] . "'>" . $etudiant['nom'] . " " . $etudiant['prénom'] . "</option>";
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
                    <?php if (isset($_POST['idEtudiant'])) { ?>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Ajouter une note</h6>
                            </div>
                            <div class="card-body">
                                <form method="post" action="">
                                    <div id="dataTable_filter" class="dataTables_filter">
                                        <label>Test
                                            <select name="idtest" class="form-control" aria-label="Default select example">
                                                <?php
                                                foreach ($tests as $key => $test) {
                                                    echo "<option value='" . $test['id'] . "'>" .
                                                        $test['id'] . ' - ' .
                                                        $test['libellétypetest'] . ' - ' .
                                                        $test['nomcours'] . ' - ' .
                                                        $test['nomtest'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </label>
                                        <label>Note
                                            <input name="note" type="text" class="form-control form-control-sm" placeholder="" aria-controls="dataTable">
                                        </label>
                                        <input type="hidden" name="idEtudiant" value="<?= $_POST['idEtudiant'] ?>">
                                        <label>
                                            <input type="submit" class="form-control btn btn-primary" value="Valider" />
                                        </label>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Notes</h6>
                            </div>
                            <div class="card-body">
                                <?php
                                foreach ($cours as $cour) {
                                    $moyenne = $db->getMoyenneCoursEtudiant2($_POST['idEtudiant'], $cour['id']);
                                    if ($moyenne != null) {
                                        $roundedMoyenne = round($moyenne[0]['average'], 2);
                                    } else {
                                        $roundedMoyenne = 0;
                                    }
                                ?>

                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary"><?= $cour['nom'] . " Moyenne: " . $roundedMoyenne ?></h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>Nom</th>
                                                            <th>Type</th>
                                                            <th>Moyenne de classe</th>
                                                            <th>coefficient</th>
                                                            <th>Note</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($notes as $note) {
                                                            echo "<tr>";
                                                            $moyenneClasse = $db->getMoyenneParTest($note['idtest']);
                                                            $moyenneClasseRounded = round($moyenneClasse[0]['average'] ?? 0, 2);
                                                            if ($note['idcours'] == $cour['id']) {
                                                                echo '<td>' . $note['nom'] . '</td>';
                                                                echo '<td>' . $note['libellé'] . '</td>';
                                                                echo '<td>' . $moyenneClasseRounded . '</td>';
                                                                echo '<td>' . $note['coefficient'] . '</td>';
                                                                echo '<td>' . $note['note'] . '</td>';
                                                            }
                                                            echo "</tr>";
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                <?php } ?>
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