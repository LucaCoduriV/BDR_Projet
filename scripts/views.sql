DROP VIEW IF EXISTS horaire;
CREATE VIEW horaire AS
SELECT leçon.*, début.heuredébut, fin.heurefin
FROM leçon
INNER JOIN plagehoraire AS début ON début.numéro = leçon.noplagehoraire
INNER JOIN plagehoraire AS fin ON fin.numéro = (leçon.noplagehoraire + leçon.nbrpériodes - 1);

DROP VIEW IF EXISTS notes;
CREATE VIEW notes AS
SELECT * FROM etudiant_test
INNER JOIN test ON test.id = etudiant_test.idtest
INNER JOIN typetest ON test.libellétypetest = typetest.libellé;