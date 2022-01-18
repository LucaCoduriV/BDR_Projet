<?php
require_once('./models/Student.php');

class Database
{
    private PDO $connexion;

    function __construct()
    {
        $this->connexion = new PDO('pgsql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_NAME'), 'postgres', 'password');
    }

    function getStudent(): array
    {
        $sql = 'SELECT * FROM etudiant';
        $request = $this->connexion->query($sql);
        return $request->fetchAll(PDO::FETCH_CLASS, 'Student');;
    }
}
