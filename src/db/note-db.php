<?php
/*
-----------------------------------------------------------------------------------
Nom du fichier : lessonstype-db.php
Auteur(s)      : Coduri Luca, Praz Tobie, Louis Hadrien
Date creation  : 20.01.2022
Description    : Ce fichier définit les methodes permettant de gérer les types de leçon
                 dans la base de données
Remarque(s)    : -
-----------------------------------------------------------------------------------
*/

class Note
{

    private PDO $connexion;

    function __construct(PDO $connexion)
    {
        $this->connexion = $connexion;
    }

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

    function deleteNote(int $idEtudiant, int $idTest)
    {
        $sql = <<<'SQL'
        DELETE FROM etudiant_test 
        WHERE etudiant_test.idtest = :idtest AND etudiant_test.idetudiant = :idetudiant;
        SQL;

        $sth = $this->connexion->prepare($sql);
        $sth->bindParam('idtest', $idTest, PDO::PARAM_INT);
        $sth->bindParam('idetudiant', $idEtudiant, PDO::PARAM_INT);
        $sth->execute();
        return $sth->errorInfo();
    }
}
