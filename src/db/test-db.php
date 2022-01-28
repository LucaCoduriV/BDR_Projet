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

class Test
{

    private PDO $connexion;

    function __construct(PDO $connexion)
    {
        $this->connexion = $connexion;
    }

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
}
