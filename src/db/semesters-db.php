<?php
/*
-----------------------------------------------------------------------------------
Nom du fichier : semesters-db.php
Auteur(s)      : Coduri Luca, Praz Tobie, Louis Hadrien
Date creation  : 20.01.2022
Description    : Ce fichier définit les methodes permettant de gérer les semestres
                 dans la base de données
Remarque(s)    : -
-----------------------------------------------------------------------------------
*/

class Semestre
{

    private PDO $connexion;

    function __construct(PDO $connexion)
    {
        $this->connexion = $connexion;
    }

    function getSemestres()
    {
        $sql = <<<'SQL'
        SELECT *
        FROM semestre
        ORDER BY année DESC;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->execute();
        return $sth->fetchAll();
    }

    function getSemestre($annee, $numero)
    {
        $sql = <<<'SQL'
        SELECT *
        FROM semestre
        WHERE année = :annee AND numéro = :numero;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('annee', $annee);
        $sth->bindParam('numero', $numero);

        $sth->execute();
        return $sth->fetchAll();
    }

    function ajouterSemestre($annee, $numero, $semaineDebut, $semaineFin)
    {
        $sql = <<<'SQL'
        INSERT INTO semestre (année, numéro, semainedébut, semainefin) 
        VALUES (:annee, :numero, :semainedebut, :semainefin);
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('annee', $annee);
        $sth->bindParam('numero', $numero);
        $sth->bindParam('semainedebut', $semaineDebut);
        $sth->bindParam('semainefin', $semaineFin);

        $sth->execute();
        return $sth->errorInfo();
    }

    function supprimerSemestre($annee, $numero)
    {
        $sql = <<<'SQL'
        DELETE FROM semestre WHERE année = :annee AND numéro = :numero;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('annee', $annee);
        $sth->bindParam('numero', $numero);

        $sth->execute();

        return $sth->errorInfo();
    }

    function modifierSemestre($oldannee, $oldnumero, $annee, $numero, $semainedebut, $semainefin)
    {
        $sql = <<<'SQL'
        UPDATE semestre
        SET année = :annee, numéro = :numero, semainedébut = :semainedebut, semainefin = :semainefin
        WHERE année = :oldannee AND numéro = :oldnumero
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('annee', $annee);
        $sth->bindParam('numero', $numero);
        $sth->bindParam('semainedebut', $semainedebut);
        $sth->bindParam('semainefin', $semainefin);
        $sth->bindParam('oldannee', $oldannee);
        $sth->bindParam('oldnumero', $oldnumero);

        $sth->execute();
        return $sth->errorInfo();
    }

}