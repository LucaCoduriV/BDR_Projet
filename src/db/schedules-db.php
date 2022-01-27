<?php
/*
-----------------------------------------------------------------------------------
Nom du fichier : buildings-db.php
Auteur(s)      : Coduri Luca, Praz Tobie, Louis Hadrien
Date creation  : 20.01.2022
Description    : Ce fichier définit les methodes permettant de gérer les plages horaire
                 dans la base de données
Remarque(s)    : -
-----------------------------------------------------------------------------------
*/

class Horaire
{

    private PDO $connexion;

    function __construct(PDO $connexion)
    {
        $this->connexion = $connexion;
    }
    
    function getHoraire(): array
    {
        $sql = <<<'SQL'
        SELECT leçon.*, début.heuredébut, fin.heurefin
        FROM leçon
        INNER JOIN plagehoraire as début on début.numéro = leçon.noplagehoraire
        INNER JOIN plagehoraire as fin on fin.numéro = (leçon.noplagehoraire + leçon.nbrpériodes - 1);
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->execute();

        return $sth->fetchAll();
    }

    function getHoraireEtudiant($noSemestre, $anneeSemestre, $etudiantId): array
    {

        $sql = <<<'SQL'
        SELECT * FROM etudiant
        INNER JOIN etudiant_leçon ON etudiant.idpersonne = etudiant_leçon.idetudiant
        INNER JOIN horaire ON horaire.numéro = etudiant_leçon.noleçon AND horaire.idcours = etudiant_leçon.idleçon
        INNER JOIN professeur ON horaire.idprofessseur = professeur.idpersonne
        INNER JOIN personne ON etudiant.idpersonne = personne.id
        INNER JOIN cours ON horaire.idcours = cours.id
        WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :anneesemestre AND etudiant.idpersonne = :etudiantid;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('nosemestre', $noSemestre, PDO::PARAM_INT);
        $sth->bindParam('anneesemestre', $anneeSemestre, PDO::PARAM_INT);
        $sth->bindParam('etudiantid', $etudiantId, PDO::PARAM_INT);
        $sth->execute();

        return $sth->fetchAll();
    }

    function getHoraireProf(int $noSemestre, int $anneeSemestre, int $idProfessseur)
    {
        $sql = <<<'SQL'
        SELECT * FROM professeur
        INNER JOIN horaire on horaire.idprofessseur = professeur.idpersonne
        INNER JOIN personne on professeur.idpersonne = personne.id
        INNER JOIN cours on horaire.idcours = cours.id
        WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :anneesemestre AND professeur.idpersonne = :idprofessseur;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('nosemestre', $noSemestre, PDO::PARAM_INT);
        $sth->bindParam('anneesemestre', $anneeSemestre, PDO::PARAM_INT);
        $sth->bindParam('idprofessseur', $idProfessseur, PDO::PARAM_INT);


        return $sth->fetchAll();
    }

    function getHoraireCours(int $noSemestre, int $anneeSemestre): array
    {
        $sql = <<<'SQL'
        SELECT * FROM cours
        INNER JOIN horaire on cours.id = horaire.idcours
        INNER JOIN professeur on horaire.idprofessseur = professeur.idpersonne
        WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :anneesemestre;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('nosemestre', $noSemestre, PDO::PARAM_INT);
        $sth->bindParam('anneesemestre', $anneeSemestre, PDO::PARAM_INT);


        return $sth->fetchAll();
    }
}