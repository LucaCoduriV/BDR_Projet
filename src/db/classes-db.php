<?php
/*
-----------------------------------------------------------------------------------
Nom du fichier : classes-db.php
Auteur(s)      : Coduri Luca, Praz Tobie, Louis Hadrien
Date creation  : 20.01.2022
Description    : Ce fichier définit les methodes permettant de gérer les cours
                 dans la base de données
Remarque(s)    : -
-----------------------------------------------------------------------------------
*/

class Cours
{

    private PDO $connexion;

    function __construct(PDO $connexion)
    {
        $this->connexion = $connexion;
    }
    
    function getAllCours()
    {
        $sql = <<<'SQL'
        SELECT *
        FROM cours;
        SQL;

        $sth = $this->connexion->prepare($sql);

        $sth->execute();

        return $sth->fetchAll();
    }

    function ajouterCours($nom, $semainedebut, $dureesemaine, $anneeetude, $noSemestre, $anneeSemestre)
    {
        $sql = <<<'SQL'
        INSERT INTO cours (nom, semainedébut, duréesemaine, annéeetude, nosemestre, annéesemestre)
        VALUES (:nom, :semainedebut, :dureesemaine, :anneeetude, :nosemestre, :anneesemestre);
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('nom', $nom);
        $sth->bindParam('semainedebut', $semainedebut);
        $sth->bindParam('dureesemaine', $dureesemaine);
        $sth->bindParam('anneeetude', $anneeetude);
        $sth->bindParam('nosemestre', $noSemestre);
        $sth->bindParam('anneesemestre', $anneeSemestre);

        $sth->execute();
        return $sth->errorInfo();
    }

    function supprimerCours($id)
    {
        $sql = <<<'SQL'
        DELETE FROM cours WHERE id = :id;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('id', $id);

        $sth->execute();

        return $sth->errorInfo();
    }

    function getCours($id)
    {
        $sql = <<<'SQL'
        SELECT *
        FROM cours
        WHERE id = :id;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('id', $id);

        $sth->execute();

        return $sth->fetchAll();
    }

    function getCoursEtudiant($idEtudiant)
    {
        $sql = <<<'SQL'
        SELECT DISTINCT cours.id, cours.nom, cours.annéeetude, cours.annéesemestre
        FROM cours
        INNER JOIN leçon l on cours.id = l.idcours
        INNER JOIN etudiant_leçon el on l.numéro = el.noleçon and l.idcours = el.idleçon
        INNER JOIN etudiant e on el.idetudiant = e.idpersonne
        WHERE e.idpersonne = :idetudiant;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('idetudiant', $idEtudiant);

        $sth->execute();

        return $sth->fetchAll();
    }

    function modifierCours($id, $nom, $semainedebut, $dureesemaine, $anneeetude, $nosemestre, $anneesemestre)
    {
        $sql = <<<'SQL'
        UPDATE cours
        SET nom = :nom, semainedébut = :semainedebut, duréesemaine = :dureesemaine, 
        annéeetude = :anneeetude, nosemestre = :nosemestre, annéesemestre = :anneesemestre
        WHERE id = :id;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('id', $id);
        $sth->bindParam('nom', $nom);
        $sth->bindParam('semainedebut', $semainedebut);
        $sth->bindParam('dureesemaine', $dureesemaine);
        $sth->bindParam('anneeetude', $anneeetude);
        $sth->bindParam('nosemestre', $nosemestre);
        $sth->bindParam('anneesemestre', $anneesemestre);

        $sth->execute();

        return $sth->errorInfo();
    }
}