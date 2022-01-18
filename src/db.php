<?php
require_once('./models/Student.php');

class Database
{
    private PDO $connexion;

    function __construct()
    {
        $this->connexion = new PDO('pgsql:host=db_server;port=5432;dbname=school', 'postgres', 'password');
    }

    function getStudent(): array
    {
        $sql = 'SELECT * FROM etudiant';
        $request = $this->connexion->query($sql);
        return $request->fetchAll(PDO::FETCH_CLASS, 'Student');;
    }
}
