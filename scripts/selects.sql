-- Horaire
CREATE VIEW horaire AS
SELECT leçon.*, début.heuredébut, fin.heurefin
FROM leçon
INNER JOIN plagehoraire AS début ON début.numéro = leçon.noplagehoraire
INNER JOIN plagehoraire AS fin ON fin.numéro = (leçon.noplagehoraire + leçon.nbrpériodes - 1);

-- Horaire étudiants
SELECT * FROM etudiant
INNER JOIN etudiant_leçon ON etudiant.idpersonne = etudiant_leçon.idetudiant
INNER JOIN horaire ON horaire.numéro = etudiant_leçon.noleçon AND horaire.idcours = etudiant_leçon.idleçon
INNER JOIN professeur ON horaire.idprofessseur = professeur.idpersonne
INNER JOIN personne ON etudiant.idpersonne = personne.id
INNER JOIN cours ON horaire.idcours = cours.id
WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :anneesemestre;

-- Horaire prof
SELECT * FROM professeur
INNER JOIN horaire ON horaire.idprofessseur = professeur.idpersonne
INNER JOIN personne ON professeur.idpersonne = personne.id
INNER JOIN cours ON horaire.idcours = cours.id
WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :anneesemestre AND professeur.idpersonne = :idprofessseur;

-- Horaire cours
SELECT * FROM cours
INNER JOIN horaire ON cours.id = horaire.idcours
INNER JOIN professeur ON horaire.idprofessseur = professeur.idpersonne
WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :anneesemestre;

-- Notes d'un élève
CREATE VIEW notes AS
SELECT * FROM etudiant_test
INNER JOIN test ON test.id = etudiant_test.idtest
INNER JOIN typetest ON test.libellétypetest = typetest.libellé;

-- Moyenne par cours par étudiant
SELECT notes.idetudiant, notes.idcours, SUM(notes.note * notes.coefficient) / SUM(notes.coefficient) AS moyenne
FROM notes
INNER JOIN cours ON notes.idcours = cours.id
WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :anneesemestre
GROUP BY notes.idcours, notes.idetudiant;


-- STATS
-- Horaires
-- Taux d'occupation des salles
SELECT (
    SELECT COUNT(DISTINCT (leçon.nosalle, leçon.nomsalle))
    FROM cours
    INNER JOIN leçon ON cours.id = leçon.idcours
    WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :anneesemestre AND leçon.nomsalle = :nombâtiment
) / CAST((COUNT(*)) AS DECIMAL) AS "taux"
FROM salle
WHERE nombâtiment = :nombâtiment;

-- Nombre moyen de cours suivis par étudiant
SELECT (COUNT(DISTINCT (etudiant_leçon.idleçon, etudiant_leçon.idetudiant)) / COUNT(DISTINCT etudiant_leçon.idetudiant)) AS moyenne
FROM etudiant_leçon
INNER JOIN cours ON etudiant_leçon.idleçon = cours.id
WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :anneesemestre;

-- Nombre moyen de leçon par professeur
SELECT AVG(nbLeçons.nb) AS moyenne
FROM (
    SELECT COUNT(*) AS nb
    FROM leçon
    INNER JOIN cours ON leçon.idcours = cours.id
    INNER JOIN etudiant_leçon ON leçon.numéro = etudiant_leçon.noleçon AND leçon.idcours = etudiant_leçon.idleçon
    WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :anneesemestre
    GROUP BY etudiant_leçon.idetudiant
) AS nbLeçons;

-- Nombre moyen de leçon par professeur
SELECT AVG(nbLeçons.nb) AS moyenne
FROM (
    SELECT COUNT(*) AS nb
    FROM leçon
    INNER JOIN cours ON leçon.idcours = cours.id
    WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :anneesemestre
    GROUP BY idprofessseur
) AS nbLeçons;

-- Taux élèves async
SELECT (
    SELECT CAST((COUNT(*)) AS DECIMAL)
    FROM (
        SELECT DISTINCT etudiant_leçon.idetudiant
        FROM etudiant_leçon
        INNER JOIN cours ON etudiant_leçon.idleçon = cours.id
        --WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :anneesemestre
        GROUP BY etudiant_leçon.idetudiant, cours.annéeetude
        HAVING COUNT(cours.annéeetude) = 2
    ) AS async
) / COUNT(DISTINCT etudiant_leçon.idetudiant) AS "taux"
FROM etudiant_leçon
INNER JOIN cours ON etudiant_leçon.idleçon = cours.id
WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :anneesemestre;

-- Notes
-- Taux échec
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

-- Taux échec par prof
WITH moyennes AS (
    SELECT notes.idetudiant, (SUM(notes.note * notes.coefficient) / SUM(notes.coefficient)) AS moyenne
    FROM notes
    WHERE notes.idcours = :idcours
    GROUP BY notes.idetudiant
)
SELECT élèves.idprofessseur, (échecs.nbEchecs / élèves.nbElèves) AS "taux"
FROM (
    SELECT leçon.idprofessseur, COUNT(DISTINCT (moyennes.idetudiant)) AS nbEchecs
    FROM moyennes
    INNER JOIN etudiant_leçon ON moyennes.idetudiant = etudiant_leçon.idetudiant
    INNER JOIN leçon ON etudiant_leçon.noleçon = leçon.numéro and etudiant_leçon.idleçon = leçon.idcours
    WHERE etudiant_leçon.idleçon = :idcours AND moyenne < 4.0
    GROUP BY leçon.idprofessseur
) AS échecs
INNER JOIN (
    SELECT leçon.idprofessseur, CAST((COUNT(DISTINCT (moyennes.idetudiant))) AS DECIMAL) AS nbElèves
    FROM moyennes
    INNER JOIN etudiant_leçon ON moyennes.idetudiant = etudiant_leçon.idetudiant
    INNER JOIN leçon ON etudiant_leçon.noleçon = leçon.numéro and etudiant_leçon.idleçon = leçon.idcours
    WHERE leçon.idcours = :idcours
    GROUP BY leçon.idprofessseur
) AS élèves ON échecs.idprofessseur = élèves.idprofessseur;

-- Moyenne générale
SELECT AVG(notes.moyenne) AS "moyenne"
FROM (
     SELECT notes.idetudiant, (SUM(notes.note * notes.coefficient) / SUM(notes.coefficient)) AS moyenne
     FROM notes
     INNER JOIN cours ON notes.idcours = cours.id
     WHERE cours.nosemestre = :nosemestre AND cours.annéesemestre = :anneesemestre
     GROUP BY notes.idcours, notes.idetudiant
) AS notes
GROUP BY notes.idetudiant;

-- Etudiants
-- Taux terminé selon type
SELECT (
    SELECT COUNT(*)
    FROM etudiant
    WHERE statut != 'En cours'
) / NULLIF(CAST((COUNT(*)) AS DECIMAL), 0) AS "taux"
FROM etudiant
WHERE statut = :statut;