<?php

class PlageHoraire
{

    private PDO $connexion;

    function __construct(PDO $connexion)
    {
        $this->connexion = $connexion;
    }
    
    function getPlagesHoraire()
    {
        $sql = <<<'SQL'
        SELECT *
        FROM plagehoraire;
        SQL;

        $sth = $this->connexion->prepare($sql);

        $sth->execute();
        return $sth->fetchAll();
    }

    function ajouterPlageHoraire($numero, $heuredebut, $heurefin)
    {
        $sql = <<<'SQL'
        INSERT INTO plagehoraire (numéro, heuredébut, heurefin)
        VALUES (:numero, :heuredebut, :heurefin);
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('numero', $numero);
        $sth->bindParam('heuredebut', $heuredebut);
        $sth->bindParam('heurefin', $heurefin);

        $sth->execute();
        return $sth->errorInfo();
    }

    function supprimerPlageHoraire($numero)
    {
        $sql = <<<'SQL'
        DELETE FROM plagehoraire WHERE numéro = :numero;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('numero', $numero);

        $sth->execute();

        return $sth->errorInfo();
    }

    function getPlageHoraire($numero)
    {
        $sql = <<<'SQL'
        SELECT *
        FROM plagehoraire
        WHERE numéro = :numero;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('numero', $numero);

        $sth->execute();
        return $sth->fetchAll();
    }

    function modifierPlageHoraire($oldnumero, $numero, $heuredebut, $heurefin)
    {
        $sql = <<<'SQL'
        UPDATE plagehoraire
        SET numéro = :numero, heuredébut = :heuredebut, heurefin = :heurefin
        WHERE numéro = :oldnumero;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('numero', $numero);
        $sth->bindParam('heuredebut', $heuredebut);
        $sth->bindParam('heurefin', $heurefin);
        $sth->bindParam('oldnumero', $oldnumero);

        $sth->execute();
        return $sth->errorInfo();
    }
}