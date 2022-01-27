<?php
/*
-----------------------------------------------------------------------------------
Nom du fichier : etudiants-db.php
Auteur(s)      : Coduri Luca, Praz Tobie, Louis Hadrien
Date creation  : 20.01.2022
Description    : Ce fichier définit les methodes permettant de gérer les étudiants
                 dans la base de données
Remarque(s)    : -
-----------------------------------------------------------------------------------
*/

class Etudiant
{

    private PDO $connexion;

    function __construct(PDO $connexion)
    {
        $this->connexion = $connexion;
    }
    
    public function modifierEtudiant($id, $nom, $prenom, $dateNaissance, $statut, $souhaiteMacaron, $distanceDomicile)
    {
        $this->connexion->beginTransaction();

        $sql = <<<'SQL'
        UPDATE personne
        SET nom = :nom, datenaissance = :dateNaissance, souhaitemacaron = :souhaitemacaron, distancedomicilekm = :distancedomicilekm
        WHERE id = :id
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

        $sql = <<<'SQL'
        UPDATE etudiant
        SET statut = :statut
        WHERE idpersonne = :idpersonne
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('statut', $statut);
        $sth->bindParam('idpersonne', $id);

        $sth->execute();

        if ($sth->errorInfo()[0] != "00000") {
            $this->connexion->rollBack();
            return $sth->errorInfo();
        }

        $sql = <<<'SQL'
        UPDATE prénom
        SET prénom = :prenom
        WHERE idpersonne = :idpersonne
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

    public function ajouterEtudiant($nom, $prenom, $dateNaissance, $souhaiteMacaron, $distanceDomicile, $statut)
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
        INSERT INTO etudiant (idpersonne, statut)
        VALUES (:id, :statut);
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('id', $id);
        $sth->bindParam('statut', $statut);
        $sth->execute();

        if ($sth->errorInfo()[0] != "00000") {
            $this->connexion->rollBack();
            return $sth->errorInfo();
        }

        $this->connexion->commit();
        return $sth->errorInfo();
    }

    public function getEtudiant($id)
    {
        $sql = <<<'SQL'
        SELECT *
        FROM etudiant
        INNER JOIN personne on etudiant.idpersonne = personne.id
        INNER JOIN prénom on personne.id = prénom.idpersonne
        WHERE personne.id = :id;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('id', $id);

        $sth->execute();

        return $sth->fetchAll();
    }

    public function getEtudiants()
    {
        $sql = <<<'SQL'
        SELECT *
        FROM etudiant
        INNER JOIN personne on etudiant.idpersonne = personne.id
        INNER JOIN prénom on personne.id = prénom.idpersonne
        ORDER BY etudiant.idpersonne DESC;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->execute();

        return $sth->fetchAll();
    }

    public function supprimerEtudiant($id)
    {
        $sql = <<<'SQL'
        DELETE FROM personne WHERE id = :id;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('id', $id);

        $sth->execute();

        return $sth->errorInfo();
    }
}