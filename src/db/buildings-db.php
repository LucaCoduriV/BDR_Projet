<?php
/*
-----------------------------------------------------------------------------------
Nom du fichier : buildings-db.php
Auteur(s)      : Coduri Luca, Praz Tobie, Louis Hadrien
Date creation  : 20.01.2022
Description    : Ce fichier définit les methodes permettant de gérer les bâtiment
                 dans la base de données
Remarque(s)    : -
-----------------------------------------------------------------------------------
*/

class Batiment
{

    private PDO $connexion;

    function __construct(PDO $connexion)
    {
        $this->connexion = $connexion;
    }
    
    function getBatiments()
    {
        $sql = <<<'SQL'
        SELECT *
        FROM bâtiment;
        SQL;

        $sth = $this->connexion->prepare($sql);

        $sth->execute();
        return $sth->fetchAll();
    }

    function getBatiment($nom)
    {
        $sql = <<<'SQL'
        SELECT *
        FROM bâtiment
        WHERE nom = :nom;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('nom', $nom);

        $sth->execute();
        return $sth->fetchAll();
    }

    function ajouterBatiment($nom, $nbrplaceparking)
    {
        $sql = <<<'SQL'
        INSERT INTO bâtiment (nom, nbrplacesparking)
        VALUES (:nom, :nbrplacesparking);
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('nom', $nom);
        $sth->bindParam('nbrplacesparking', $nbrplaceparking);

        $sth->execute();
        return $sth->errorInfo();
    }

    function supprimerBatiment($nom)
    {
        $sql = <<<'SQL'
        DELETE FROM bâtiment WHERE nom = :nom;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('nom', $nom);

        $sth->execute();

        return $sth->errorInfo();
    }

    function modifierBatiment($oldnom, $nom, $nbrplacesparking)
    {
        $sql = <<<'SQL'
        UPDATE bâtiment
        SET nom = :nom, nbrplacesparking = :nbrplacesparking
        WHERE nom = :oldnom
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('nom', $nom);
        $sth->bindParam('nbrplacesparking', $nbrplacesparking);
        $sth->bindParam('oldnom', $oldnom);

        $sth->execute();
        return $sth->errorInfo();
    }
    
}