-- Horaire
CREATE VIEW horaire as
SELECT leçon.*, début.heuredébut, fin.heurefin
FROM leçon
INNER JOIN plagehoraire as début on début.numéro = leçon.noplagehoraire
INNER JOIN plagehoraire as fin on fin.numéro = (leçon.noplagehoraire + leçon.nbrpériodes - 1);

-- Horaire étudiants
SELECT * FROM etudiant
INNER JOIN etudiant_leçon on etudiant.idpersonne = etudiant_leçon.idetudiant
INNER JOIN horaire on numéro = etudiant_leçon.idleçon
INNER JOIN professeur on horaire.idprofessseur = professeur.idpersonne
INNER JOIN personne on etudiant.idpersonne = personne.id
INNER JOIN cours on horaire.idcours = cours.id
WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :annéeesemestre;

-- Horaire prof
SELECT * FROM professeur
INNER JOIN horaire on horaire.idprofessseur = professeur.idpersonne
INNER JOIN personne on professeur.idpersonne = personne.id
INNER JOIN cours on horaire.idcours = cours.id
WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :annéeesemestre;

-- Horaire cours
SELECT * FROM cours
INNER JOIN horaire on cours.id = horaire.idcours
INNER JOIN professeur on horaire.idprofessseur = professeur.idpersonne
WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :annéeesemestre;

-- Notes d'un élève
CREATE VIEW notes as
SELECT * FROM etudiant_test
INNER JOIN test on test.id = etudiant_test.idtest
INNER JOIN typetest on test.libellétypetest = typetest.libellé
INNER JOIN cours on test.idcours = cours.id
WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :annéeesemestre;

-- Moyenne par cours par étudiant
SELECT notes.idetudiant, notes.idcours, SUM(notes.note * notes.coefficient) / COUNT(*) as average
FROM notes
GROUP BY notes.idcours, notes.idetudiant;


-- STATS
-- Horaires

-- Nombre moyen de cours suivis par étudiant
SELECT COUNT(DISTINCT (etudiant_leçon.idleçon, etudiant_leçon.idetudiant)) / COUNT(DISTINCT etudiant_leçon.idetudiant)
FROM etudiant_leçon
INNER JOIN cours on etudiant_leçon.idleçon = cours.id
WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :annéeesemestre;

-- Taux élèves async
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

-- Notes
-- Moyenne générale
SELECT AVG(notes.average)
FROM (
     SELECT notes.idetudiant, SUM(notes.note * notes.coefficient) / COUNT(*) as average
     FROM notes
     GROUP BY notes.idcours, notes.idetudiant
) as notes
GROUP BY notes.idetudiant;

-- Etudiants