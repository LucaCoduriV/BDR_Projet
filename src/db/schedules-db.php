<?php
/*
-----------------------------------------------------------------------------------
Nom du fichier : buildings-db.php
Auteur(s)      : Coduri Luca, Praz Tobie, Louis Hadrien
Date creation  : 20.01.2022
Description    : Ce fichier définit les methodes permettant de gérer les horaires
                 dans la base de données (etudiants / professeurs)
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
        $sth->execute();

        return $sth->fetchAll();
    }

}