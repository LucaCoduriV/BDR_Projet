<?php

class Statut
{
    private PDO $connexion;

    function __construct(PDO $connexion)
    {
        $this->connexion = $connexion;
    }

    function getAllStatut()
    {
        $sql = <<<'SQL'
        SELECT *
        FROM statut;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->execute();

        return $sth->fetchAll();
    }

    function ajouterStatut($libelle)
    {
        $sql = <<<'SQL'
        INSERT INTO statut (libellé)
        VALUES (:libelle);
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('libelle', $libelle);

        $sth->execute();
        return $sth->errorInfo();
    }

    function supprimerStatut($libelle)
    {
        $sql = <<<'SQL'
        DELETE FROM statut WHERE libellé = :libelle;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('libelle', $libelle);

        $sth->execute();

        return $sth->errorInfo();
    }

    function getStatus($libelle)
    {
        $sql = <<<'SQL'
        SELECT *
        FROM statut
        WHERE libellé = :libelle;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('libelle', $libelle);

        $sth->execute();
        return $sth->fetchAll();
    }

    function modifierStatut($oldlibelle, $libelle)
    {
        $sql = <<<'SQL'
        UPDATE statut
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