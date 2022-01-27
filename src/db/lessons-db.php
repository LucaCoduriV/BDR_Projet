<?php
/*
-----------------------------------------------------------------------------------
Nom du fichier : lessons-db.php
Auteur(s)      : Coduri Luca, Praz Tobie, Louis Hadrien
Date creation  : 20.01.2022
Description    : Ce fichier définit les methodes permettant de gérer les leçons
                 dans la base de données
Remarque(s)    : -
-----------------------------------------------------------------------------------
*/

class Lecon
{

    private PDO $connexion;

    function __construct(PDO $connexion)
    {
        $this->connexion = $connexion;
    }
    
    function ajouterLecon($idcours, $idprofesseur, $noplagehoraire, $libelletypeleçon, $nosalle, $nomsalle, $nbrperiodes, $joursemaine)
    {
        $sql = <<<'SQL'
        SELECT MAX(numéro) FROM leçon WHERE idcours = :idcours;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('idcours', $idcours);
        $sth->execute();

        $nextid = $sth->fetchAll()[0]['max'] + 1;

        $sql = <<<'SQL'
        INSERT INTO leçon (numéro, idcours, idprofessseur, noplagehoraire, libellétypeleçon, nosalle, nomsalle, nbrpériodes, joursemaine)
        VALUES (:numero, :idcours, :idprofesseur, :noplagehoraire, :libelletypeleeon, :nosalle, :nomsalle, :nbrperiodes, :joursemaine);
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('numero', $nextid);
        $sth->bindParam('idcours', $idcours);
        $sth->bindParam('idprofesseur', $idprofesseur);
        $sth->bindParam('noplagehoraire', $noplagehoraire);
        $sth->bindParam('libelletypeleeon', $libelletypeleçon);
        $sth->bindParam('nosalle', $nosalle);
        $sth->bindParam('nomsalle', $nomsalle);
        $sth->bindParam('nbrperiodes', $nbrperiodes);
        $sth->bindParam('joursemaine', $joursemaine);

        $sth->execute();

        return $sth->errorInfo();
    }

    
    function getLecons()
    {
        $sql = <<<'SQL'
        SELECT leçon.numéro, cours.nom AS nomcours, cours.id AS idcours, personne.nom AS nomprof, prénom.prénom AS prenomprof,
        début.heuredébut, fin.heurefin AS heurefin, nosalle, nomsalle,
        libellétypeleçon AS typelecon, leçon.joursemaine, personne.id, leçon.nbrpériodes
        FROM leçon
        INNER JOIN professeur ON leçon.idprofessseur = professeur.idpersonne
        INNER JOIN personne ON professeur.idpersonne = personne.id
        INNER JOIN cours ON leçon.idcours = cours.id
        INNER JOIN prénom ON personne.id = prénom.idpersonne
        INNER JOIN plagehoraire AS début ON début.numéro = leçon.noplagehoraire
        INNER JOIN plagehoraire AS fin ON fin.numéro = (leçon.noplagehoraire + leçon.nbrpériodes - 1);
        SQL;

        $sth = $this->connexion->prepare($sql);

        $sth->execute();

        return $sth->fetchAll();
    }

    function supprimerLecon($numero, $idcours)
    {
        $sql = <<<'SQL'
        DELETE FROM leçon WHERE numéro = :numero AND idcours = :idcours;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('numero', $numero);
        $sth->bindParam('idcours', $idcours);

        $sth->execute();

        return $sth->errorInfo();
    }

    function getLecon($numero, $idcours)
    {
        $sql = <<<'SQL'
        SELECT leçon.numéro, cours.nom AS nomcours, cours.id AS idcours, personne.nom AS nomprof, prénom.prénom AS prenomprof,
        début.heuredébut, fin.heurefin AS heurefin, début.heuredébut, nosalle, nomsalle,
        libellétypeleçon AS typelecon, leçon.joursemaine, personne.id, leçon.nbrpériodes,
        professeur.idpersonne AS idprof, début.numéro AS numeroplagehoraire
        FROM leçon
        INNER JOIN professeur ON leçon.idprofessseur = professeur.idpersonne
        INNER JOIN personne ON professeur.idpersonne = personne.id
        INNER JOIN cours ON leçon.idcours = cours.id
        INNER JOIN prénom ON personne.id = prénom.idpersonne
        INNER JOIN plagehoraire AS début ON début.numéro = leçon.noplagehoraire
        INNER JOIN plagehoraire AS fin ON fin.numéro = (leçon.noplagehoraire + leçon.nbrpériodes - 1)
        WHERE leçon.numéro = :numero AND cours.id = :idcours;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('numero', $numero);
        $sth->bindParam('idcours', $idcours);

        $sth->execute();

        return $sth->fetchAll();
    }

    function modifierLecon(
        $idprofesseur,
        $noplagehoraire,
        $libelletypelecon,
        $nosalle,
        $nombatiment,
        $nbrperiodes,
        $joursemaine,
        $numero,
        $idcours
    ) {
        $sql = <<<'SQL'
        UPDATE leçon SET idprofessseur = :idprofessseur, noplagehoraire = :noplagehoraire, libellétypeleçon = :libelletypelecon, 
        nosalle = :nosalle, nomsalle = :nomsalle, nbrpériodes = :nbrperiodes, joursemaine = :joursemaine
        WHERE numéro = :numero AND idcours = :idcours;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('idprofessseur', $idprofesseur);
        $sth->bindParam('noplagehoraire', $noplagehoraire);
        $sth->bindParam('libelletypelecon', $libelletypelecon);
        $sth->bindParam('nosalle', $nosalle);
        $sth->bindParam('nomsalle', $nombatiment);
        $sth->bindParam('nbrperiodes', $nbrperiodes);
        $sth->bindParam('joursemaine', $joursemaine);
        $sth->bindParam('numero', $numero);
        $sth->bindParam('idcours', $idcours);

        $sth->execute();

        return $sth->errorInfo();
    }
    
    function ajouterEtudiantsLecon($etudiants, $nolecon, $idcours) {
        $sql = <<<'SQL'
        INSERT INTO etudiant_leçon (noleçon, idleçon, idetudiant)  
        VALUES (:nolecon, :idlecon, :idetudiant)
        SQL;

        foreach($etudiants as $etudiant) {
            $sth = $this->connexion->prepare($sql);
            $sth->bindParam('nolecon', $nolecon);
            $sth->bindParam('idlecon', $idcours);
            $sth->bindParam('idetudiant', $etudiant);

            $sth->execute();
        }        

        return $sth->errorInfo();
    }

    function getEtudiantsLecon($idlecon) {
        $sql = <<<'SQL'
        SELECT etudiant.idpersonne
        FROM etudiant
        INNER JOIN personne ON etudiant.idpersonne = personne.id
        INNER JOIN etudiant_leçon ON etudiant.idpersonne = etudiant_leçon.idetudiant
        INNER JOIN leçon ON etudiant_leçon.noleçon = leçon.numéro AND etudiant_leçon.idleçon = leçon.idcours
        WHERE leçon.numéro = :idlecon;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('idlecon', $idlecon);

        $sth->execute();
        return $sth->fetchAll();
    }

    function supprimerEtudiantsLecon($etudiants, $nolecon, $idcours)
    {
        $sql = <<<'SQL'
        DELETE FROM etudiant_leçon
        WHERE idetudiant = :idetudiant AND idleçon = :idlecon AND noleçon = :nolecon
        SQL;

        foreach ($etudiants as $etudiant) {
            $sth = $this->connexion->prepare($sql);
            $sth->bindParam('nolecon', $nolecon);
            $sth->bindParam('idlecon', $idcours);
            $sth->bindParam('idetudiant', $etudiant);

            $sth->execute();
        }

        return $sth->errorInfo();
    }
}