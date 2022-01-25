<?php

require_once('DotEnv.php');
(new DotEnv(__DIR__ . '/.env'))->load();

class Database
{
    private PDO $connexion;

    function __construct()
    {
        $this->connexion = new PDO('pgsql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_NAME'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
        $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
    }

    function getStatut()
    {
        $sql = <<<'SQL'
        SELECT *
        FROM statut;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->execute();

        return $sth->fetchAll();
    }

    function modifierEtudiant($id, $nom, $prenom, $dateNaissance, $statut, $souhaiteMacaron, $distanceDomicile)
    {
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

        $res = $sth->execute();

        if ($sth->errorInfo()[0] != "00000") {
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

        $res = $sth->execute();

        $sql = <<<'SQL'
        UPDATE prénom
        SET prénom = :prenom
        WHERE idpersonne = :idpersonne
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('prenom', $prenom);
        $sth->bindParam('idpersonne', $id);

        $res = $sth->execute();

        return $sth->errorInfo();
    }

    function ajouterEtudiant($nom, $prenom, $dateNaissance, $souhaiteMacaron, $distanceDomicile, $statut)
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
        INSERT INTO etudiant (idpersonne, statut)
        VALUES (:id, :statut);
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('id', $id);
        $sth->bindParam('statut', $statut);
        $res = $sth->execute();

        return $sth->errorInfo();
    }

    function getEtudiant($id)
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

    function getEtudiants()
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

    function supprimerEtudiant($id)
    {
        $sql = <<<'SQL'
        DELETE FROM personne WHERE id = :id;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('id', $id);

        $sth->execute();

        return $sth->errorInfo();
    }

    function getHoraire(): array
    {
        $sql = <<<'SQL'
        SELECT leçon.*, début.heuredébut, fin.heurefin
        FROM leçon
        INNER JOIN plagehoraire as début on début.numéro = leçon.noplagehoraire
        INNER JOIN plagehoraire as fin on fin.numéro = (leçon.noplagehoraire + leçon.nbrpériodes - 1);
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->execute();

        return $sth->fetchAll();
    }

    function getHoraireEtudiant(int $noSemestre, int $anneeSemestre, int $etudiantId): array
    {
        
        $sql = <<<'SQL'
        SELECT * FROM etudiant
        INNER JOIN etudiant_leçon on etudiant.idpersonne = etudiant_leçon.idetudiant
        INNER JOIN horaire on numéro = etudiant_leçon.idleçon
        INNER JOIN professeur on horaire.idprofessseur = professeur.idpersonne
        INNER JOIN personne on etudiant.idpersonne = personne.id
        INNER JOIN cours on horaire.idcours = cours.id
        WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :anneeesemestre AND etudiant.idpersonne = :etudiantid;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('nosemestre', $noSemestre, PDO::PARAM_INT);
        $sth->bindParam('anneeesemestre', $anneeSemestre, PDO::PARAM_INT);
        $sth->bindParam('etudiantid', $etudiantId, PDO::PARAM_INT);
        $sth->execute();

        return $sth->fetchAll();
    }

    function getHoraireProf(int $noSemestre, int $anneeSemestre)
    {
        $sql = <<<'SQL'
        SELECT * FROM professeur
        INNER JOIN horaire on horaire.idprofessseur = professeur.idpersonne
        INNER JOIN personne on professeur.idpersonne = personne.id
        INNER JOIN cours on horaire.idcours = cours.id
        WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :annéeesemestre;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('nosemestre', $noSemestre, PDO::PARAM_INT);
        $sth->bindParam('annéeesemestre', $anneeSemestre, PDO::PARAM_INT);


        return $sth->fetchAll();
    }

    function getHoraireCours(int $noSemestre, int $anneeSemestre): array
    {
        $sql = <<<'SQL'
        SELECT * FROM cours
        INNER JOIN horaire on cours.id = horaire.idcours
        INNER JOIN professeur on horaire.idprofessseur = professeur.idpersonne
        WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :annéeesemestre;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('nosemestre', $noSemestre, PDO::PARAM_INT);
        $sth->bindParam('annéeesemestre', $anneeSemestre, PDO::PARAM_INT);


        return $sth->fetchAll();
    }

    function getNoteEleve(int $noSemestre, int $anneeSemestre): array
    {
        $sql = <<<'SQL'
        SELECT * FROM etudiant_test
        INNER JOIN test on test.id = etudiant_test.idtest
        INNER JOIN typetest on test.libellétypetest = typetest.libellé
        INNER JOIN cours on test.idcours = cours.id
        WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :annéeesemestre;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('nosemestre', $noSemestre, PDO::PARAM_INT);
        $sth->bindParam('annéeesemestre', $anneeSemestre, PDO::PARAM_INT);


        return $sth->fetchAll();
    }

    function getMoyenneCoursEtudiant(): array
    {
        $sql = <<<'SQL'
        SELECT notes.idetudiant, notes.idcours, SUM(notes.note * notes.coefficient) / COUNT(*) as average
        FROM notes
        GROUP BY notes.idcours, notes.idetudiant;
        SQL;

        $sth = $this->connexion->prepare($sql);
        return $sth->fetchAll();
    }

    function getNombreMoyenCoursSuivi(int $noSemestre, int $anneeSemestre): array
    {
        $sql = <<<'SQL'
        SELECT COUNT(DISTINCT (etudiant_leçon.idleçon, etudiant_leçon.idetudiant)) / COUNT(DISTINCT etudiant_leçon.idetudiant)
        FROM etudiant_leçon
        INNER JOIN cours on etudiant_leçon.idleçon = cours.id
        WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :annéeesemestre;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('nosemestre', $noSemestre, PDO::PARAM_INT);
        $sth->bindParam('annéeesemestre', $anneeSemestre, PDO::PARAM_INT);


        return $sth->fetchAll();
    }

    function getTauxEleveAsync(int $noSemestre, int $anneeSemestre): array
    {
        $sql = <<<'SQL'
        SELECT COUNT((
            SELECT DISTINCT etudiant_leçon.idetudiant
            FROM etudiant_leçon
            INNER JOIN cours on etudiant_leçon.idleçon = cours.id
            WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :annéeesemestre
            GROUP BY etudiant_leçon.idetudiant, cours.annéeetude
            HAVING COUNT(cours.annéeetude) = 2
        )) / COUNT(DISTINCT etudiant_leçon.idetudiant)
        FROM etudiant_leçon
        INNER JOIN cours on etudiant_leçon.idleçon = cours.id
        WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :annéeesemestre;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('nosemestre', $noSemestre, PDO::PARAM_INT);
        $sth->bindParam('annéeesemestre', $anneeSemestre, PDO::PARAM_INT);


        return $sth->fetchAll();
    }

    function getMoyenneGeneral(): array
    {
        $sql = <<<'SQL'
        SELECT AVG(notes.average)
        FROM (
            SELECT notes.idetudiant, SUM(notes.note * notes.coefficient) / COUNT(*) as average
            FROM notes
            GROUP BY notes.idcours, notes.idetudiant
        ) as notes
        GROUP BY notes.idetudiant;
        SQL;

        $sth = $this->connexion->prepare($sql);
        return $sth->fetchAll();
    }

    function getSemestres()
    {
        $sql = <<<'SQL'
        SELECT *
        FROM semestre
        ORDER BY année DESC;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->execute();
        return $sth->fetchAll();
    }

    function getSemestre($annee, $numero)
    {
        $sql = <<<'SQL'
        SELECT *
        FROM semestre
        WHERE année = :annee AND numéro = :numero;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('annee', $annee);
        $sth->bindParam('numero', $numero);

        $sth->execute();
        return $sth->fetchAll();
    }

    function ajouterSemestre($annee, $numero, $semaineDebut, $semaineFin)
    {
        $sql = <<<'SQL'
        INSERT INTO semestre (année, numéro, semainedébut, semainefin) 
        VALUES (:annee, :numero, :semainedebut, :semainefin);
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('annee', $annee);
        $sth->bindParam('numero', $numero);
        $sth->bindParam('semainedebut', $semaineDebut);
        $sth->bindParam('semainefin', $semaineFin);

        $sth->execute();
        return $sth->errorInfo();
    }

    function supprimerSemestre($annee, $numero)
    {
        $sql = <<<'SQL'
        DELETE FROM semestre WHERE année = :annee AND numéro = :numero;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('annee', $annee);
        $sth->bindParam('numero', $numero);

        $sth->execute();

        return $sth->errorInfo();
    }

    function modifierSemestre($oldannee, $oldnumero, $annee, $numero, $semainedebut, $semainefin)
    {
        $sql = <<<'SQL'
        UPDATE semestre
        SET année = :annee, numéro = :numero, semainedébut = :semainedebut, semainefin = :semainefin
        WHERE année = :oldannee AND numéro = :oldnumero
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('annee', $annee);
        $sth->bindParam('numero', $numero);
        $sth->bindParam('semainedebut', $semainedebut);
        $sth->bindParam('semainefin', $semainefin);
        $sth->bindParam('oldannee', $oldannee);
        $sth->bindParam('oldnumero', $oldnumero);

        $sth->execute();
        return $sth->errorInfo();
    }

    function getBatiments()
    {
        $sql = <<<'SQL'
        SELECT *
        FROM bâtiment;
        SQL;

        $sth = $this->connexion->prepare($sql);

        $sth->execute();
        return $sth->fetchAll();
    }

    function getBatiment($nom)
    {
        $sql = <<<'SQL'
        SELECT *
        FROM bâtiment
        WHERE nom = :nom;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('nom', $nom);

        $sth->execute();
        return $sth->fetchAll();
    }

    function ajouterBatiment($nom, $nbrplaceparking)
    {
        $sql = <<<'SQL'
        INSERT INTO bâtiment (nom, nbrplacesparking)
        VALUES (:nom, :nbrplacesparking);
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('nom', $nom);
        $sth->bindParam('nbrplacesparking', $nbrplaceparking);

        $sth->execute();
        return $sth->errorInfo();
    }

    function supprimerBatiment($nom)
    {
        $sql = <<<'SQL'
        DELETE FROM bâtiment WHERE nom = :nom;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('nom', $nom);

        $sth->execute();

        return $sth->errorInfo();
    }

    function modifierBatiment($oldnom, $nom, $nbrplacesparking)
    {
        $sql = <<<'SQL'
        UPDATE bâtiment
        SET nom = :nom, nbrplacesparking = :nbrplacesparking
        WHERE nom = :oldnom
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('nom', $nom);
        $sth->bindParam('nbrplacesparking', $nbrplacesparking);
        $sth->bindParam('oldnom', $oldnom);

        $sth->execute();
        return $sth->errorInfo();
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

    function getAllCours()
    {
        $sql = <<<'SQL'
        SELECT *
        FROM cours;
        SQL;

        $sth = $this->connexion->prepare($sql);

        $sth->execute();

        return $sth->fetchAll();
    }

    function ajouterCours($nom, $semainedebut, $dureesemaine, $anneeetude, $noSemestre, $anneeSemestre)
    {
        $sql = <<<'SQL'
        INSERT INTO cours (nom, semainedébut, duréesemaine, annéeetude, nosemestre, annéesemestre)
        VALUES (:nom, :semainedebut, :dureesemaine, :anneeetude, :nosemestre, :anneesemestre);
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('nom', $nom);
        $sth->bindParam('semainedebut', $semainedebut);
        $sth->bindParam('dureesemaine', $dureesemaine);
        $sth->bindParam('anneeetude', $anneeetude);
        $sth->bindParam('nosemestre', $noSemestre);
        $sth->bindParam('anneesemestre', $anneeSemestre);

        $sth->execute();
        return $sth->errorInfo();
    }

    function supprimerCours($id)
    {
        $sql = <<<'SQL'
        DELETE FROM cours WHERE id = :id;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('id', $id);

        $sth->execute();

        return $sth->errorInfo();
    }

    function getCours($id)
    {
        $sql = <<<'SQL'
        SELECT *
        FROM cours
        WHERE id = :id;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('id', $id);

        $sth->execute();

        return $sth->fetchAll();
    }

    function modifierCours($id, $nom, $semainedebut, $dureesemaine, $anneeetude, $nosemestre, $anneesemestre)
    {
        $sql = <<<'SQL'
        UPDATE cours
        SET nom = :nom, semainedébut = :semainedebut, duréesemaine = :dureesemaine, 
        annéeetude = :anneeetude, nosemestre = :nosemestre, annéesemestre = :anneesemestre
        WHERE id = :id;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('id', $id);
        $sth->bindParam('nom', $nom);
        $sth->bindParam('semainedebut', $semainedebut);
        $sth->bindParam('dureesemaine', $dureesemaine);
        $sth->bindParam('anneeetude', $anneeetude);
        $sth->bindParam('nosemestre', $nosemestre);
        $sth->bindParam('anneesemestre', $anneesemestre);

        $sth->execute();

        return $sth->errorInfo();
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

    function modifierLecon($idprofesseur, $noplagehoraire, $libelletypelecon, $nosalle, 
        $nombatiment, $nbrperiodes, $joursemaine, $numero, $idcours)
    {
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

    
    function getAllTypeLecon()
    {
        $sql = <<<'SQL'
        SELECT * FROM typeleçon;
        SQL;

        $sth = $this->connexion->prepare($sql);

        $sth->execute();
        
        return $sth->fetchAll();
    }
}

$db = new Database();
