-- Horaire
CREATE VIEW horaire AS
SELECT leçon.*, début.heuredébut, fin.heurefin
FROM leçon
INNER JOIN plagehoraire AS début ON début.numéro = leçon.noplagehoraire
INNER JOIN plagehoraire AS fin ON fin.numéro = (leçon.noplagehoraire + leçon.nbrpériodes - 1);

-- Horaire étudiants
SELECT * FROM etudiant
INNER JOIN etudiant_leçon ON etudiant.idpersonne = etudiant_leçon.idetudiant
INNER JOIN horaire ON numéro = etudiant_leçon.noleçon AND idcours = etudiant_leçon.idleçon
INNER JOIN professeur ON horaire.idprofessseur = professeur.idpersonne
INNER JOIN personne ON etudiant.idpersonne = personne.id
INNER JOIN cours ON horaire.idcours = cours.id
WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :annéeesemestre;

-- Horaire prof
SELECT * FROM professeur
INNER JOIN horaire ON horaire.idprofessseur = professeur.idpersonne
INNER JOIN personne ON professeur.idpersonne = personne.id
INNER JOIN cours ON horaire.idcours = cours.id
WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :annéeesemestre;

-- Horaire cours
SELECT * FROM cours
INNER JOIN horaire ON cours.id = horaire.idcours
INNER JOIN professeur ON horaire.idprofessseur = professeur.idpersonne
WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :annéeesemestre;

-- Notes d'un élève
CREATE VIEW notes AS
SELECT * FROM etudiant_test
INNER JOIN test ON test.id = etudiant_test.idtest
INNER JOIN typetest ON test.libellétypetest = typetest.libellé;

-- Moyenne par cours par étudiant
SELECT notes.idetudiant, notes.idcours, SUM(notes.note) / COUNT(*) AS moyenne
FROM notes
INNER JOIN cours ON notes.idcours = cours.id
WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :annéeesemestre
GROUP BY notes.idcours, notes.idetudiant;


-- STATS
-- Horaires

-- Nombre moyen de cours suivis par étudiant
SELECT (COUNT(DISTINCT (etudiant_leçon.idleçon, etudiant_leçon.idetudiant)) / COUNT(DISTINCT etudiant_leçon.idetudiant)) AS moyenne
FROM etudiant_leçon
INNER JOIN cours ON etudiant_leçon.idleçon = cours.id
WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :annéeesemestre;

-- Taux élèves async
SELECT (
    SELECT COUNT(*)
    FROM (
        SELECT DISTINCT etudiant_leçon.idetudiant
        FROM etudiant_leçon
        INNER JOIN cours ON etudiant_leçon.idleçon = cours.id
        --WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :annéeesemestre
        GROUP BY etudiant_leçon.idetudiant, cours.annéeetude
        HAVING COUNT(cours.annéeetude) = 2
    ) AS async
) / COUNT(DISTINCT etudiant_leçon.idetudiant) AS "taux async"
FROM etudiant_leçon
INNER JOIN cours ON etudiant_leçon.idleçon = cours.id
WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :annéeesemestre;

-- Notes
-- Taux échec

WITH moyennes AS (
    SELECT (SUM(notes.note * notes.coefficient) / COUNT(*)) AS moyenne
    FROM notes
    WHERE notes.idcours = :idcours
    GROUP BY notes.idetudiant
)
SELECT (
    SELECT COUNT(*)
    FROM moyennes
    WHERE moyenne < 4.0
) / COUNT(*)
FROM moyennes;

-- Moyenne générale
SELECT AVG(notes.moyenne)
FROM (
     SELECT notes.idetudiant, SUM(notes.note * notes.coefficient) / COUNT(*) AS moyenne
     FROM notes
     INNER JOIN cours ON notes.idcours = cours.id
     WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :annéeesemestre
     GROUP BY notes.idcours, notes.idetudiant
) AS notes
GROUP BY notes.idetudiant;

-- Etudiants
-- Taux terminé selon type
SELECT (
    SELECT COUNT(*)
    FROM etudiant
    WHERE statut != 'En cours'
) / COUNT(*)
FROM etudiant
WHERE statut = :status;