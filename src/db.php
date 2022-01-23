<?php
//require_once('../models/Student.php');

require_once('DotEnv.php');
(new DotEnv(__DIR__ . '/.env'))->load();

class Database
{
    private PDO $connexion;

    function __construct()
    {
        $this->connexion = new PDO('pgsql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_NAME'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
        $this->connexion->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT );
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

    function modifierEtudiant($id, $nom, $prenom, $dateNaissance, $statut, $souhaiteMacaron, $distanceDomicile) {
        $sql = <<<'SQL'
        UPDATE personne
        SET nom = :nom, datenaissance = :dateNaissance, souhaitemacaron = :souhaitemacaron, distancedomicilekm = :distancedomicilekm
        WHERE id = :id
        SQL;

        $sth->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('nom', $nom);
        $sth->bindParam('dateNaissance', $dateNaissance);
        $sth->bindParam('souhaitemacaron', $souhaiteMacaron);
        $sth->bindParam('distancedomicilekm', $distanceDomicile);
        $sth->bindParam('id', $id);

        $res = $sth->execute();

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

    function ajouterEtudiant($nom, $prenom, $dateNaissance, $souhaiteMacaron, $distanceDomicile, $statut) {
    
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

    function getEtudiant($id) {
        $sql = <<<'SQL'
        SELECT *
        FROM etudiant
        INNER JOIN personne on etudiant.idpersonne = personne.id
        INNER JOIN prénom on personne.id = prénom.idpersonne
        WHERE personne.id = :id
        ORDER BY etudiant.idpersonne DESC;
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

        return $sth->fetchAll();
    }

    function getHoraireEtudiant(int $noSemestre, int $anneeSemestre): array
    {
        $sql = <<<'SQL'
        SELECT * FROM etudiant
        INNER JOIN etudiant_leçon on etudiant.idpersonne = etudiant_leçon.idetudiant
        INNER JOIN horaire on numéro = etudiant_leçon.idleçon
        INNER JOIN professeur on horaire.idprofessseur = professeur.idpersonne
        INNER JOIN personne on etudiant.idpersonne = personne.id
        INNER JOIN cours on horaire.idcours = cours.id
        WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :annéeesemestre;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('nosemestre', $noSemestre, PDO::PARAM_INT);
        $sth->bindParam('annéeesemestre', $anneeSemestre, PDO::PARAM_INT);


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

    function supprimerSemestre($annee, $numero) {
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

    function supprimerBatiment($nom) {
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

    function supprimerPlageHoraire($numero) {
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
}

$db = new Database();

?>
