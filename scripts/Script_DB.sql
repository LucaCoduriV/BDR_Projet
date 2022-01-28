SET client_encoding TO 'UTF-8';

DROP DOMAIN IF EXISTS type_libellé CASCADE;
CREATE DOMAIN type_libellé VARCHAR(30);

DROP TABLE IF EXISTS Personne CASCADE;
CREATE TABLE Personne(
    id SMALLSERIAL,
    nom VARCHAR(50) NOT NULL,
    dateNaissance DATE NOT NULL,
    souhaiteMacaron BOOLEAN NOT NULL DEFAULT FALSE,
    distanceDomicileKm SMALLINT NOT NULL,
    CONSTRAINT PK_Personne PRIMARY KEY(id),
	CONSTRAINT CK_Personne_distanceDomicileKm CHECK (distanceDomicileKm >= 0),
	CONSTRAINT CK_Personne_dateNaissance CHECK (dateNaissance < CURRENT_DATE)
);

DROP TABLE IF EXISTS Prénom CASCADE;
CREATE TABLE Prénom(
    idPersonne SMALLINT,
    prénom VARCHAR(50),
    CONSTRAINT PK_Prénom PRIMARY KEY(prénom, idPersonne)
);

DROP TABLE IF EXISTS Etudiant CASCADE;
CREATE TABLE Etudiant(
	idPersonne SMALLINT,
    statut type_libellé NOT NULL,
    CONSTRAINT PK_Etudiant PRIMARY KEY(idPersonne)
);

DROP TABLE IF EXISTS Statut CASCADE;
CREATE TABLE Statut(
    libellé type_libellé,
    CONSTRAINT PK_TypeDépart PRIMARY KEY(libellé)
);

DROP TABLE IF EXISTS Professeur CASCADE;
CREATE TABLE Professeur(
    idPersonne SMALLINT,
    trigramme CHAR(3) NOT NULL,
    CONSTRAINT PK_Professeur PRIMARY KEY(idPersonne),
    CONSTRAINT UC_trigramme UNIQUE (trigramme)
);

DROP TABLE IF EXISTS Leçon CASCADE;
CREATE TABLE Leçon(
    numéro SMALLINT,
    idCours SMALLINT,
    idProfessseur SMALLINT NOT NULL,
    noPlageHoraire SMALLINT NOT NULL,
    libelléTypeLeçon type_libellé NOT NULL,
    noSalle SMALLINT NOT NULL,
    nomSalle VARCHAR(30) NOT NULL,
    nbrPériodes SMALLINT NOT NULL,
    jourSemaine SMALLINT NOT NULL,
    CONSTRAINT PK_Leçon PRIMARY KEY(numéro, idCours),
    CONSTRAINT CK_Leçon_nbrPériodes CHECK (nbrPériodes > 0),
    CONSTRAINT CK_Leçon_jourSemaine CHECK (jourSemaine BETWEEN 0 AND 6)
);

DROP TABLE IF EXISTS TypeLeçon CASCADE;
CREATE TABLE TypeLeçon(
    libellé type_libellé,
    CONSTRAINT PK_TypeLeçon PRIMARY KEY(libellé)
);

DROP TABLE IF EXISTS Etudiant_Leçon CASCADE;
CREATE TABLE Etudiant_Leçon(
    noLeçon SMALLINT,
    idLeçon SMALLINT,
    idEtudiant SMALLINT,
    CONSTRAINT PK_Etudiant_Leçon PRIMARY KEY(noLeçon, idLeçon, idEtudiant)
);

DROP TABLE IF EXISTS Salle CASCADE;
CREATE TABLE Salle(
    numéro SMALLINT,
    nomBâtiment VARCHAR(30),
    CONSTRAINT PK_Salle PRIMARY KEY(numéro, nomBâtiment)
);

DROP TABLE IF EXISTS Bâtiment CASCADE;
CREATE TABLE Bâtiment(
    nom VARCHAR(30),
    nbrPlacesParking SMALLINT NOT NULL DEFAULT 0,
    CONSTRAINT PK_Bâtiment PRIMARY KEY(nom),
    CONSTRAINT CK_Bâtiment_nbrPlacesParking CHECK (nbrPlacesParking >= 0)
);

DROP TABLE IF EXISTS PlageHoraire CASCADE;
CREATE TABLE PlageHoraire(
    numéro SMALLINT,
    heureDébut TIME NOT NULL,
    heureFin TIME NOT NULL,
    CONSTRAINT PK_PlageHoraire PRIMARY KEY(numéro),
    CONSTRAINT CK_PlageHoraire_heureFin CHECK (heureFin > heureDébut)
);

DROP TABLE IF EXISTS Etudiant_Test CASCADE;
CREATE TABLE Etudiant_Test(
    idEtudiant SMALLINT,
    idTest SMALLINT,
    note DECIMAL(3, 2) NOT NULL DEFAULT 1,
    CONSTRAINT PK_Etudiant_Test PRIMARY KEY(idEtudiant, idTest),
    CONSTRAINT CK_Etudiant_Test_note CHECK (note BETWEEN 1 AND 6)
);

DROP TABLE IF EXISTS TypeTest CASCADE;
CREATE TABLE TypeTest(
    libellé type_libellé,
    coefficient DECIMAL(3, 2) NOT NULL,
    CONSTRAINT PK_TypeTest PRIMARY KEY(libellé),
    CONSTRAINT CK_TypeTest_coefficient CHECK(coefficient BETWEEN 0 AND 1)
);

DROP TABLE IF EXISTS Test CASCADE;
CREATE TABLE Test(
    id SMALLSERIAL,
    idCours SMALLINT NOT NULL,
    libelléTypeTest type_libellé NOT NULL,
    nom VARCHAR(50),
    CONSTRAINT PK_Test PRIMARY KEY(id)
);

DROP TABLE IF EXISTS Cours CASCADE;
CREATE TABLE Cours(
    id SMALLSERIAL,
    nom VARCHAR(30) NOT NULL,
    semaineDébut SMALLINT NOT NULL,
    duréeSemaine SMALLINT NOT NULL,
    annéeEtude SMALLINT NOT NULL,
    noSemestre SMALLINT NOT NULL,
    annéeSemestre SMALLINT NOT NULL,
    CONSTRAINT PK_Cours PRIMARY KEY(id),
    CONSTRAINT UC_Cours UNIQUE (nom, semaineDébut, noSemestre, annéeSemestre),
    CONSTRAINT CK_Cours_annéeEtude CHECK(annéeEtude BETWEEN 1 AND 3)
);

DROP TABLE IF EXISTS Semestre CASCADE;
CREATE TABLE Semestre(
    année SMALLINT,
    numéro SMALLINT,
    semaineDébut SMALLINT NOT NULL,
    semaineFin SMALLINT NOT NULL,
    CONSTRAINT PK_Semestre PRIMARY KEY(année, numéro),
    CONSTRAINT CK_Semestre_no CHECK (numéro = 1 OR numéro = 2)
);

-- CONSTRAINT
ALTER TABLE Professeur
    ADD CONSTRAINT FK_Professeur_idPersonne
        FOREIGN KEY(idPersonne) REFERENCES Personne(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE;

ALTER TABLE Etudiant
    ADD CONSTRAINT FK_Etudiant_idPersonne
        FOREIGN KEY(idPersonne) REFERENCES Personne(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    ADD CONSTRAINT FK_Etudiant_statut
        FOREIGN KEY(statut) REFERENCES Statut(libellé)
        ON UPDATE CASCADE;

ALTER TABLE Prénom
    ADD CONSTRAINT FK_Prénom_idPersonne
        FOREIGN KEY(idPersonne) REFERENCES Personne(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE;

ALTER TABLE Test
    ADD CONSTRAINT FK_Test_idCours
        FOREIGN KEY(idCours) REFERENCES Cours(id)
        ON UPDATE CASCADE,
    ADD CONSTRAINT FK_Test_libelléTypeTest
        FOREIGN KEY(libelléTypeTest) REFERENCES TypeTest(libellé)
        ON UPDATE CASCADE;

ALTER TABLE Etudiant_Test
    ADD CONSTRAINT FK_Etudiant_Test_idEtudiant
        FOREIGN KEY(idEtudiant) REFERENCES Etudiant(idPersonne)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    ADD CONSTRAINT FK_Etudiant_Test_idTest
        FOREIGN KEY(idTest) REFERENCES Test(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE;

ALTER TABLE Cours
    ADD CONSTRAINT FK_Cours_noSemestreAnnéeSemestre
        FOREIGN KEY(noSemestre, annéeSemestre) REFERENCES Semestre(numéro, année)
        ON UPDATE CASCADE;

ALTER TABLE Salle
    ADD CONSTRAINT FK_Salle_nomBâtiment
        FOREIGN KEY(nomBâtiment) REFERENCES Bâtiment(nom)
        ON DELETE CASCADE
        ON UPDATE CASCADE;

ALTER TABLE Leçon
    ADD CONSTRAINT FK_Leçon_idProfesseur
        FOREIGN KEY(idProfessseur) REFERENCES Professeur(idPersonne)
        ON UPDATE CASCADE,
    ADD CONSTRAINT FK_Leçon_noSalleNomBâtiment
        FOREIGN KEY(noSalle, nomSalle) REFERENCES Salle(numéro, nomBâtiment)
        ON UPDATE CASCADE,
    ADD CONSTRAINT FK_Leçon_noPlageHoraire
        FOREIGN KEY(noPlageHoraire) REFERENCES PlageHoraire(numéro)
        ON UPDATE CASCADE,
    ADD CONSTRAINT FK_Leçon_idCours
        FOREIGN KEY(idCours) REFERENCES Cours(id)
        ON UPDATE CASCADE,
    ADD CONSTRAINT FK_Leçon_libelléTypeLeçon
        FOREIGN KEY(libelléTypeLeçon) REFERENCES TypeLeçon(libellé)
        ON UPDATE CASCADE;

ALTER TABLE Etudiant_Leçon
    ADD CONSTRAINT FK_Etudiant_Leçon
        FOREIGN KEY(noLeçon, idLeçon) REFERENCES Leçon(numéro, idCours)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    ADD CONSTRAINT FK_Etudiant_Etudiant
        FOREIGN KEY(idEtudiant) REFERENCES Etudiant(idPersonne)
        ON DELETE CASCADE
        ON UPDATE CASCADE;
