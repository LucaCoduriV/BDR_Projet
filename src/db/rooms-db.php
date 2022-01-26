<?php

class Salle
{

    private PDO $connexion;

    function __construct(PDO $connexion)
    {
        $this->connexion = $connexion;
    }
    
    function getSalles()
    {
        $sql = <<<'SQL'
        SELECT *
        FROM salle; 
        SQL;

        $sth = $this->connexion->prepare($sql);

        $sth->execute();

        return $sth->fetchAll();
    }

    function supprimerSalle($numero, $nombatiment)
    {
        $sql = <<<'SQL'
        DELETE FROM salle WHERE numéro = :numero AND nombâtiment = :nombatiment;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('numero', $numero);
        $sth->bindParam('nombatiment', $nombatiment);

        $sth->execute();

        return $sth->errorInfo();
    }

    function ajouterSalle($numero, $nombatiment)
    {
        $sql = <<<'SQL'
        INSERT INTO salle (numéro, nombâtiment)
        VALUES (:numero, :nombatiment);
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('numero', $numero);
        $sth->bindParam('nombatiment', $nombatiment);

        $sth->execute();

        return $sth->errorInfo();
    }

    function getSalle($numero, $nombatiment)
    {
        $sql = <<<'SQL'
        SELECT *
        FROM salle
        WHERE numéro = :numero AND nombâtiment = :nombatiment;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('numero', $numero);
        $sth->bindParam('nombatiment', $nombatiment);

        $sth->execute();

        return $sth->fetchAll();
    }

    function modifierSalle($numero, $nombatiment, $oldnumero, $oldnombatiment)
    {
        $sql = <<<'SQL'
        UPDATE salle
        SET numéro = :numero, nombâtiment = :nombatiment
        WHERE numéro = :oldnumero AND nombâtiment = :oldnombatiment;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('numero', $numero);
        $sth->bindParam('nombatiment', $nombatiment);
        $sth->bindParam('oldnumero', $oldnumero);
        $sth->bindParam('oldnombatiment', $oldnombatiment);

        $sth->execute();
        return $sth->errorInfo();
    }
}