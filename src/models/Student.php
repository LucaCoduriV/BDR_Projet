<?php
class Student
{
    public int $idPersonne;
    public string $statut;

    function __construct()
    {
        $this->idPersonne = intval($this->idPersonne);;
    }
}
