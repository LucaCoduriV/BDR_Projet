<?php
//require_once('../models/Student.php');

require_once('DotEnv.php');
(new DotEnv(__DIR__ . '/.env'))->load();

class Database
{
    private PDO $connexion;
    private $dbconn;

    function __construct()
    {
        $this->connexion = new PDO('pgsql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_NAME'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
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

        return;
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
}

$db = new Database();

?>
