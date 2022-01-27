<?php
/*
-----------------------------------------------------------------------------------
Nom du fichier : teachers-db.php
Auteur(s)      : Coduri Luca, Praz Tobie, Louis Hadrien
Date creation  : 20.01.2022
Description    : Ce fichier définit les methodes permettant de gérer les professeurs
                 dans la base de données
Remarque(s)    : -
-----------------------------------------------------------------------------------
*/

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
        $this->connexion->beginTransaction();

        $sql = <<<'SQL'
        INSERT INTO personne (nom, datenaissance, souhaitemacaron, distancedomicilekm) 
        VALUES (:nom, :dateNaissance, :souhaitemacaron, :distancedomicile);
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('nom', $nom);
        $sth->bindParam('dateNaissance', $dateNaissance);
        $sth->bindParam('souhaitemacaron', $souhaiteMacaron);
        $sth->bindParam('distancedomicile', $distanceDomicile);

        $sth->execute();
        if ($sth->errorInfo()[0] != "00000") {
            $this->connexion->rollBack();
            return $sth->errorInfo();
        }

        $id = $this->connexion->lastInsertId();

        $sql = <<<'SQL'
        INSERT INTO prénom (idpersonne, prénom) 
        VALUES (:idpersonne, :prenom);
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('prenom', $prenom);
        $sth->bindParam('idpersonne', $id);
        $sth->execute();
        if ($sth->errorInfo()[0] != "00000") {
            $this->connexion->rollBack();
            return $sth->errorInfo();
        }

        $sql = <<<'SQL'
        INSERT INTO professeur (idpersonne, trigramme)
        VALUES (:id, :trigramme);
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('id', $id);
        $sth->bindParam('trigramme', $trigramme);
        $sth->execute();
        if ($sth->errorInfo()[0] != "00000") {
            $this->connexion->rollBack();
            return $sth->errorInfo();
        }

        $this->connexion->commit();
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
        $this->connexion->beginTransaction();
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

        $sth->execute();
        if ($sth->errorInfo()[0] != "00000") {
            $this->connexion->rollBack();
            return $sth->errorInfo();
        }

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

        $sth->execute();
        if ($sth->errorInfo()[0] != "00000") {
            $this->connexion->rollBack();
            return $sth->errorInfo();
        }

        $sql = <<<'SQL'
        UPDATE prénom
        SET prénom = :prenom
        WHERE idpersonne = :idpersonne;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('prenom', $prenom);
        $sth->bindParam('idpersonne', $id);

        $sth->execute();
        if ($sth->errorInfo()[0] != "00000") {
            $this->connexion->rollBack();
            return $sth->errorInfo();
        }

        $this->connexion->commit();
        return $sth->errorInfo();
    }

    
}