<?php
/*
-----------------------------------------------------------------------------------
Nom du fichier : testtypes-db.php
Auteur(s)      : Coduri Luca, Praz Tobie, Louis Hadrien
Date creation  : 20.01.2022
Description    : Ce fichier définit les methodes permettant de gérer les types de test
                 dans la base de données
Remarque(s)    : -
-----------------------------------------------------------------------------------
*/

class TypeTest
{

    private PDO $connexion;

    function __construct(PDO $connexion)
    {
        $this->connexion = $connexion;
    }
    
    function getTypesTest()
    {
        $sql = <<<'SQL'
        SELECT *
        FROM typetest;
        SQL;

        $sth = $this->connexion->prepare($sql);

        $sth->execute();
        return $sth->fetchAll();
    }

    function ajouterTypeTest($libelle, $coefficient)
    {
        $sql = <<<'SQL'
        INSERT INTO typetest (libellé, coefficient)
        VALUES (:libelle, :coefficient);
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('libelle', $libelle);
        $sth->bindParam('coefficient', $coefficient);

        $sth->execute();
        return $sth->errorInfo();
    }

    function supprimerTypeTest($libelle)
    {
        $sql = <<<'SQL'
        DELETE FROM typetest WHERE libellé = :libelle;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('libelle', $libelle);

        $sth->execute();

        return $sth->errorInfo();
    }

    function getTypeTest($libelle)
    {
        $sql = <<<'SQL'
        SELECT *
        FROM typetest
        WHERE libellé = :libelle;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('libelle', $libelle);

        $sth->execute();
        return $sth->fetchAll();
    }

    function modifierTypeTest($oldlibelle, $libelle, $coefficient)
    {
        $sql = <<<'SQL'
        UPDATE typetest
        SET libellé = :libelle, coefficient = :coefficient
        WHERE libellé = :oldlibelle;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('libelle', $libelle);
        $sth->bindParam('coefficient', $coefficient);
        $sth->bindParam('oldlibelle', $oldlibelle);

        $sth->execute();
        return $sth->errorInfo();
    }
    
}