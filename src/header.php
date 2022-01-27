<!--
-----------------------------------------------------------------------------------
Nom du fichier : header.php
Auteur(s)      : Coduri Luca, Praz Tobie, Louis Hadrien
Date creation  : 20.01.2022
Description    : Ce fichier définit l'en-tête du site et le menu de navigation droite
Remarque(s)    : -
-----------------------------------------------------------------------------------
-->

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-text mx-3">SMS</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="/">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Tableau de bord</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Gestion
    </div>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="/pages/semesters-view.php">
            <i class="fas fa-fw fa-cog"></i>
            <span>Semestre</span></a>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="/pages/students-view.php">
            <i class="fas fa-fw fa-cog"></i>
            <span>Etudiants</span></a>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="/pages/teachers-view.php">
            <i class="fas fa-fw fa-cog"></i>
            <span>Professeurs</span></a>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="/pages/classes-view.php">
            <i class="fas fa-fw fa-cog"></i>
            <span>Cours</span></a>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="/pages/lessons-view.php">
            <i class="fas fa-fw fa-cog"></i>
            <span>Leçon</span></a>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="/pages/buildings-view.php">
            <i class="fas fa-fw fa-cog"></i>
            <span>Bâtiment</span></a>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="/pages/rooms-view.php">
            <i class="fas fa-fw fa-cog"></i>
            <span>Salle</span></a>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="/pages/timerange-view.php">
            <i class="fas fa-fw fa-cog"></i>
            <span>Plage horaire</span></a>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="/pages/testtype-view.php">
            <i class="fas fa-fw fa-cog"></i>
            <span>Type test</span></a>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="/pages/lessonstype-view.php">
            <i class="fas fa-fw fa-cog"></i>
            <span>Type leçon</span></a>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="/pages/status-view.php">
            <i class="fas fa-fw fa-cog"></i>
            <span>Statut</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="/pages/test-view.php">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Tests</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Statistiques
    </div>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="/pages/schedule-student.php">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Horaires</span></a>
    </li>



    <li class="nav-item">
        <a class="nav-link" href="/pages/notes-view.php">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Notes</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Etudiants</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->