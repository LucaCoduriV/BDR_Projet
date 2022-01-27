<?php
/*
-----------------------------------------------------------------------------------
Nom du fichier : db.php
Auteur(s)      : Coduri Luca, Praz Tobie, Louis Hadrien
Date creation  : 20.01.2022
Description    : Ce fichier initialise la connexion à la base de données
Remarque(s)    : Chaque table de la base de données possède sa propre classe contenant
                 les diverses méthodes permettant de gérer ses données. Tous les liens
                 sont effectués dans ce fichier
-----------------------------------------------------------------------------------
*/

require_once('../DotEnv.php');
include_once("db/etudiants-db.php");
include_once("db/statut-db.php");
include_once("db/teachers-db.php");
include_once("db/semesters-db.php");
include_once("db/classes-db.php");
include_once("db/lessons-db.php");
include_once("db/timeranges-db.php");
include_once("db/lessonstype-db.php");
include_once("db/rooms-db.php");
include_once("db/buildings-db.php");
include_once("db/testtypes-db.php");
include_once("db/schedules-db.php");

(new DotEnv(__DIR__ . '/.env'))->load();

class Database
{
    private PDO $connexion;
    public Etudiant $etudiant;
    public Statut $statut;
    public Professeur $professeur;
    public Semestre $semestre;
    public Cours $cours;
    public Lecon $lecon;
    public PlageHoraire $plagehoraire;
    public TypeLecon $typelecon;
    public Salle $salle;
    public Batiment $batiment;
    public TypeTest $typetest;
    public Horaire $horaire;

    function __construct()
    {
        $this->connexion = new PDO('pgsql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_NAME'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
        //$this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
        $this->etudiant = new Etudiant($this->connexion);
        $this->statut = new Statut($this->connexion);
        $this->professeur = new Professeur($this->connexion);
        $this->semestre = new Semestre($this->connexion);
        $this->cours = new Cours($this->connexion);
        $this->lecon = new Lecon($this->connexion);
        $this->plagehoraire = new PlageHoraire($this->connexion);
        $this->typelecon = new TypeLecon($this->connexion);
        $this->salle = new Salle($this->connexion);
        $this->batiment = new Batiment($this->connexion);
        $this->typetest = new TypeTest($this->connexion);
        $this->horaire = new Horaire($this->connexion);
        $this->horaire = new Horaire($this->connexion);
    }

    /** Faudra en faire une classe je pense */
    function getTests()
    {
        $sql = <<<'SQL'
        SELECT test.id, test.nom as nomTest, test.libellétypetest, cours.nom as nomcours FROM test
        INNER JOIN cours on test.idCours = cours.id
        ORDER BY nomcours;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->execute();


        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    function getTest(int $idTest)
    {
        $sql = <<<'SQL'
        SELECT test.id, test.nom as nomTest, test.libellétypetest, test.idcours, cours.nom as nomcours FROM test
        INNER JOIN cours on test.idCours = cours.id
        WHERE test.id = :idtest
        ORDER BY nomcours;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('idtest', $idTest, PDO::PARAM_INT);
        $sth->execute();


        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    function insertTest(int $idCours, string $libelletypetest, string $nom)
    {
        $sql = <<<'SQL'
        INSERT INTO test (id, idcours, libellétypetest, nom)
        VALUES (DEFAULT, :idcours, :libelletypetest, :nom);
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('idcours', $idCours, PDO::PARAM_INT);
        $sth->bindParam('libelletypetest', $libelletypetest, PDO::PARAM_STR);
        $sth->bindParam('nom', $nom, PDO::PARAM_STR);
        $sth->execute();
        return $sth->errorInfo();
    }

    function deleteTest(int $idTest)
    {
        $sql = <<<'SQL'
        DELETE FROM test WHERE test.id = :idtest;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('idtest', $idTest, PDO::PARAM_INT);
        $sth->execute();
        return $sth->errorInfo();
    }

    function updateTest(int $id, int $idCours, string $nom, string $type)
    {
        $sql = <<<'SQL'
        UPDATE test
        SET idcours = :idcours, nom = :nom, libellétypetest = :type
        WHERE id = :id;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('idcours', $idCours);
        $sth->bindParam('nom', $nom);
        $sth->bindParam('type', $type);
        $sth->bindParam('id', $id);

        $sth->execute();
        return $sth->errorInfo();
    }

    /** Fin */

    function getNotesEleve(int $idEtudiant): array
    {
        $sql = <<<'SQL'
        SELECT * FROM notes
        WHERE idetudiant = :idetudiant;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('idetudiant', $idEtudiant, PDO::PARAM_INT);
        $sth->execute();


        return $sth->fetchAll();
    }

    function insertNote($idEtudiant, $idTest, $note)
    {
        $sql = <<<'SQL'
        INSERT INTO etudiant_test (idetudiant, idtest, note)
        VALUES (:idetudiant, :idtest, :note);
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('idetudiant', $idEtudiant);
        $sth->bindParam('idtest', $idTest);
        $sth->bindParam('note', $note);
        $sth->execute();
        return $sth->errorInfo();
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

    //permet de filtrer les moyennes par cours et par étudiant
    function getMoyenneCoursEtudiant2(int $etudiantId, int $idCours): array
    {
        $sql = <<<'SQL'
        SELECT notes.idetudiant, notes.idcours, SUM(notes.note * notes.coefficient) / SUM(notes.coefficient) as average
        FROM notes
        WHERE notes.idetudiant = :etudiantid AND notes.idcours = :idcours
        GROUP BY notes.idcours, notes.idetudiant;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('etudiantid', $etudiantId, PDO::PARAM_INT);
        $sth->bindParam('idcours', $idCours, PDO::PARAM_INT);
        $sth->execute();

        return $sth->fetchAll();
    }

    function getMoyenneParTest(int $testId): array
    {
        $sql = <<<'SQL'
        SELECT notes.idtest, SUM(notes.note * notes.coefficient) / SUM(notes.coefficient) as average
        FROM notes
        WHERE notes.idtest = :testid
        GROUP BY notes.idtest;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('testid', $testId, PDO::PARAM_INT);
        $sth->execute();

        return $sth->fetchAll();
    }

    function getNombreMoyenCoursSuivi(int $noSemestre, int $anneeSemestre): float
    {
        $sql = <<<'SQL'
        SELECT COUNT(DISTINCT (etudiant_leçon.idleçon, etudiant_leçon.idetudiant)) / COUNT(DISTINCT etudiant_leçon.idetudiant) AS moyenne
        FROM etudiant_leçon
        INNER JOIN cours ON etudiant_leçon.idleçon = cours.id
        WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :anneesemestre;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('nosemestre', $noSemestre, PDO::PARAM_INT);
        $sth->bindParam('anneesemestre', $anneeSemestre, PDO::PARAM_INT);
        $sth->execute();

        return $sth->fetchAll()[0]["moyenne"];
    }

    function getNombreLeconMoyenPourEtudiants(int $noSemestre, int $anneeSemestre): float
    {
        $sql = <<<'SQL'
        SELECT AVG(nbLeçons.nb) AS moyenne
        FROM (
            SELECT COUNT(*) nb
            FROM leçon
            INNER JOIN cours ON leçon.idcours = cours.id
            INNER JOIN etudiant_leçon ON leçon.numéro = etudiant_leçon.noleçon AND leçon.idcours = etudiant_leçon.idleçon
            WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :anneesemestre
            GROUP BY etudiant_leçon.idetudiant
        ) AS nbLeçons;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('nosemestre', $noSemestre, PDO::PARAM_INT);
        $sth->bindParam('anneesemestre', $anneeSemestre, PDO::PARAM_INT);
        $sth->execute();

        return $sth->fetchAll()[0]["moyenne"];
    }

    function getNombreLeconMoyenPourProfesseurs(int $noSemestre, int $anneeSemestre): float
    {
        $sql = <<<'SQL'
        SELECT AVG(nbLeçons.nb) AS moyenne
        FROM (
            SELECT COUNT(*) nb
            FROM leçon
            INNER JOIN cours ON leçon.idcours = cours.id
            WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :anneesemestre
            GROUP BY idprofessseur
        ) AS nbLeçons;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('nosemestre', $noSemestre, PDO::PARAM_INT);
        $sth->bindParam('anneesemestre', $anneeSemestre, PDO::PARAM_INT);
        $sth->execute();

        return $sth->fetchAll()[0]["moyenne"];
    }

    function getTauxEleveAsync(int $noSemestre, int $anneeSemestre): float
    {
        $sql = <<<'SQL'
        SELECT (
            SELECT CAST((COUNT(*)) AS DECIMAL)
            FROM (
                SELECT DISTINCT etudiant_leçon.idetudiant
                FROM etudiant_leçon
                INNER JOIN cours ON etudiant_leçon.idleçon = cours.id
                --WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :annéesemestre
                GROUP BY etudiant_leçon.idetudiant, cours.annéeetude
                HAVING COUNT(cours.annéeetude) = 2
            ) AS async
        ) / COUNT(DISTINCT etudiant_leçon.idetudiant) AS "taux"
        FROM etudiant_leçon
        INNER JOIN cours ON etudiant_leçon.idleçon = cours.id
        WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :anneesemestre;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('nosemestre', $noSemestre, PDO::PARAM_INT);
        $sth->bindParam('anneesemestre', $anneeSemestre, PDO::PARAM_INT);
        $sth->execute();

        return $sth->fetchAll()[0]["taux"];
    }

    function getTauxEchec(int $idCours): float {
        $sql = <<<'SQL'
        WITH moyennes AS (
            SELECT (SUM(notes.note * notes.coefficient) / SUM(notes.coefficient)) AS moyenne
            FROM notes
            WHERE notes.idcours = :idcours
            GROUP BY notes.idetudiant
        )
        SELECT (
            SELECT COUNT(*)
            FROM moyennes
            WHERE moyenne < 4.0
        ) / CAST((COUNT(*)) AS DECIMAL) AS "taux"
        FROM moyennes;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('idcours', $idCours, PDO::PARAM_INT);
        $sth->execute();

        return $sth->fetchAll()[0]["taux"];
    }

    function getMoyenneGenerale(int $noSemestre, int $anneeSemestre): array
    {
        $sql = <<<'SQL'
        SELECT AVG(notes.moyenne) AS "moyenne"
        FROM (
             SELECT notes.idetudiant, (SUM(notes.note * notes.coefficient) / SUM(notes.coefficient)) AS moyenne
             FROM notes
             INNER JOIN cours ON notes.idcours = cours.id
             WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :anneesemestre
             GROUP BY notes.idcours, notes.idetudiant
        ) AS notes
        GROUP BY notes.idetudiant;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('nosemestre', $noSemestre, PDO::PARAM_INT);
        $sth->bindParam('anneesemestre', $anneeSemestre, PDO::PARAM_INT);
        $sth->execute();

        return $sth->fetchAll();
    }

    function getTauxElevesParStatus(string $statut): float {
        $sql = <<<'SQL'
        SELECT (
            SELECT COUNT(*)
            FROM etudiant
            WHERE statut != 'En cours'
        ) / CAST((COUNT(*)) AS DECIMAL) AS "taux"
        FROM etudiant
        WHERE statut = :statut;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('statut', $statut, PDO::PARAM_INT);
        $sth->execute();

        return $sth->fetchAll()[0]["taux"];
    }

    function getAllTestsEtudiantCanHave($idEtudiant)
    {
        $sql = <<<'SQL'
        SELECT test.id, test.nom as nomtest, test.libellétypetest, cours.nom as nomcours 
        FROM test
        INNER JOIN cours on cours.id = test.idcours
        WHERE test.idcours IN (SELECT leçon.idcours FROM etudiant_leçon
            INNER JOIN leçon on leçon.numéro = etudiant_leçon.noleçon and leçon.idcours = etudiant_leçon.idleçon
            WHERE etudiant_leçon.idetudiant = :idetudiant)
        ORDER BY nomcours;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('idetudiant', $idEtudiant);

        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
}

$db = new Database();
