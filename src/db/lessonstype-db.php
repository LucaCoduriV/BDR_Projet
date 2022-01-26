<?php

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