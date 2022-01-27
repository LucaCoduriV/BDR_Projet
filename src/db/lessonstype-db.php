<?php
/*
-----------------------------------------------------------------------------------
Nom du fichier : lessonstype-db.php
Auteur(s)      : Coduri Luca, Praz Tobie, Louis Hadrien
Date creation  : 20.01.2022
Description    : Ce fichier définit les methodes permettant de gérer les types de leçon
                 dans la base de données
Remarque(s)    : -
-----------------------------------------------------------------------------------
*/

class TypeLecon
{

    private PDO $connexion;

    function __construct(PDO $connexion)
    {
        $this->connexion = $connexion;
    }
    
    function getAllTypeLecon()
    {
        $sql = <<<'SQL'
        SELECT * FROM typeleçon;
        SQL;

        $sth = $this->connexion->prepare($sql);

        $sth->execute();

        return $sth->fetchAll();
    }

    function ajouterTypeLecon($libelle)
    {
        $sql = <<<'SQL'
        INSERT INTO typeleçon (libellé)
        VALUES (:libelle);
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('libelle', $libelle);

        $sth->execute();

        return $sth->errorInfo();
    }

    function supprimerTypeLecon($libelle)
    {
        $sql = <<<'SQL'
        DELETE FROM typeleçon WHERE libellé = :libelle;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('libelle', $libelle);

        $sth->execute();

        return $sth->errorInfo();
    }

    function getTypeLecon($libelle)
    {
        $sql = <<<'SQL'
        SELECT * FROM typeleçon WHERE libellé = :libelle;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('libelle', $libelle);

        $sth->execute();

        return $sth->fetchAll();
    }

    function modifierTypeLecon($oldlibelle, $libelle)
    {
        $sql = <<<'SQL'
        UPDATE typeleçon
        SET libellé = :libelle
        WHERE libellé = :oldlibelle;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('libelle', $libelle);
        $sth->bindParam('oldlibelle', $oldlibelle);

        $sth->execute();

        return $sth->errorInfo();
    }
}