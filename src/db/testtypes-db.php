<?php

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