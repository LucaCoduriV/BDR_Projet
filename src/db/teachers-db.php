<?php

class Professeur
{

    private PDO $connexion;

    function __construct(PDO $connexion)
    {
        $this->connexion = $connexion;
    }

    function getProfesseurs()
    {
        $sql = <<<'SQL'
        SELECT *
        FROM professeur
        INNER JOIN personne on professeur.idpersonne = personne.id
        INNER JOIN prénom on personne.id = prénom.idpersonne
        ORDER BY professeur.idpersonne DESC;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->execute();

        return $sth->fetchAll();
    }

    function ajouterProfesseur($nom, $prenom, $dateNaissance, $souhaiteMacaron, $distanceDomicile, $trigramme)
    {

        $sql = <<<'SQL'
        INSERT INTO personne (nom, datenaissance, souhaitemacaron, distancedomicilekm) 
        VALUES (:nom, :dateNaissance, :souhaitemacaron, :distancedomicile);
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('nom', $nom);
        $sth->bindParam('dateNaissance', $dateNaissance);
        $sth->bindParam('souhaitemacaron', $souhaiteMacaron);
        $sth->bindParam('distancedomicile', $distanceDomicile);

        $res = $sth->execute();

        $id = $this->connexion->lastInsertId();

        $sql = <<<'SQL'
        INSERT INTO prénom (idpersonne, prénom) 
        VALUES (:idpersonne, :prenom);
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('prenom', $prenom);
        $sth->bindParam('idpersonne', $id);
        $sth->execute();

        $sql = <<<'SQL'
        INSERT INTO professeur (idpersonne, trigramme)
        VALUES (:id, :trigramme);
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('id', $id);
        $sth->bindParam('trigramme', $trigramme);
        $res = $sth->execute();

        return $sth->errorInfo();
    }

    function supprimerProfesseur($id)
    {
        $sql = <<<'SQL'
        DELETE FROM personne WHERE id = :id;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('id', $id);

        $sth->execute();

        return $sth->errorInfo();
    }

    function getProfesseur($id)
    {
        $sql = <<<'SQL'
        SELECT *
        FROM professeur
        INNER JOIN personne on professeur.idpersonne = personne.id
        INNER JOIN prénom on personne.id = prénom.idpersonne
        WHERE personne.id = :id;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('id', $id);

        $sth->execute();

        return $sth->fetchAll();
    }

    function modifierProfesseur($id, $nom, $prenom, $dateNaissance, $trigramme, $souhaiteMacaron, $distanceDomicile)
    {
        $sql = <<<'SQL'
        UPDATE personne
        SET nom = :nom, datenaissance = :dateNaissance, souhaitemacaron = :souhaitemacaron, distancedomicilekm = :distancedomicilekm
        WHERE id = :id;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('nom', $nom);
        $sth->bindParam('dateNaissance', $dateNaissance);
        $sth->bindParam('souhaitemacaron', $souhaiteMacaron);
        $sth->bindParam('distancedomicilekm', $distanceDomicile);
        $sth->bindParam('id', $id);

        $res = $sth->execute();

        if ($sth->errorInfo()[0] != "00000") {
            return $sth->errorInfo();
        }

        $sql = <<<'SQL'
        UPDATE professeur
        SET trigramme = :trigramme
        WHERE idpersonne = :idpersonne;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('trigramme', $trigramme);
        $sth->bindParam('idpersonne', $id);

        $res = $sth->execute();

        $sql = <<<'SQL'
        UPDATE prénom
        SET prénom = :prenom
        WHERE idpersonne = :idpersonne;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('prenom', $prenom);
        $sth->bindParam('idpersonne', $id);

        $res = $sth->execute();

        return $sth->errorInfo();
    }

    
}