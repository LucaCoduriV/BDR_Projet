-- Professeur
INSERT INTO personne VALUES (1, 'Dumoulin', '1973-3-17', false, 23);
INSERT INTO prénom VALUES (1, 'Vivienne');
INSERT INTO professeur VALUES (1, 'VDN');

INSERT INTO personne VALUES(2, 'Parent', '1987-10-5', false, 45);
INSERT INTO prénom VALUES (2, 'Pierre');
INSERT INTO professeur VALUES (2, 'PPT');

INSERT INTO personne VALUES(3, 'Charest', '1992-5-21', false, 12);
INSERT INTO prénom VALUES (3, 'Antoine');
INSERT INTO professeur VALUES (3, 'ACT');

INSERT INTO personne VALUES(4, 'Lamour', '1971-1-30', false, 62);
INSERT INTO prénom VALUES (4, 'Yves');
INSERT INTO professeur VALUES (4, 'YLR');

INSERT INTO personne VALUES(5, 'Doucet', '1989-7-3', false, 32);
INSERT INTO prénom VALUES (5, 'Grégoire');
INSERT INTO professeur VALUES (5, 'GDT');

INSERT INTO personne VALUES(6, 'Crête', '1971-5-25', false, 45);
INSERT INTO prénom VALUES (6, 'Rémy');
INSERT INTO professeur VALUES (6, 'RCE');

INSERT INTO personne VALUES(107, 'Lefèbvre', '1985-12-12', false, 32);
INSERT INTO prénom VALUES (107, 'Antoine');
INSERT INTO professeur VALUES (107, 'ALE');

INSERT INTO personne VALUES(108, 'Somer', '1973-1-31', false, 10);
INSERT INTO prénom VALUES (108, 'René');
INSERT INTO professeur VALUES (108, 'RSR');

INSERT INTO personne VALUES(109, 'Dupuis', '1977-11-23', false, 39);
INSERT INTO prénom VALUES (109, 'Thomas');
INSERT INTO professeur VALUES (109, 'TDS');

INSERT INTO personne VALUES(110, 'Berthiaume', '1981-02-14', false, 52);
INSERT INTO prénom VALUES (110, 'Jacques');
INSERT INTO professeur VALUES (110, 'JBE');

INSERT INTO personne VALUES(111, 'Fortier', '1977-05-7', false, 20);
INSERT INTO prénom VALUES (111, 'Michel');
INSERT INTO professeur VALUES (111, 'MFR');

INSERT INTO personne VALUES(112, 'Chandonnet', '1987-07-16', false, 42);
INSERT INTO prénom VALUES (112, 'Emile');
INSERT INTO professeur VALUES (112, 'ECT');

INSERT INTO personne VALUES(113, 'Montminy', '1969-08-26', false, 15);
INSERT INTO prénom VALUES (113, 'Eliot');
INSERT INTO professeur VALUES (113, 'EMY');

INSERT INTO personne VALUES(114, 'Rocher', '1971-09-12', false, 53);
INSERT INTO prénom VALUES (114, 'Roger');
INSERT INTO professeur VALUES (114, 'RRR');

INSERT INTO personne VALUES(115, 'Hamilton', '1968-05-05', false, 42);
INSERT INTO prénom VALUES (115, 'David');
INSERT INTO professeur VALUES (115, 'DHN');

INSERT INTO personne VALUES(116, 'Daigneault', '1980-04-13', false, 28);
INSERT INTO prénom VALUES (116, 'Gabriel');
INSERT INTO professeur VALUES (116, 'GDL');

INSERT INTO personne VALUES(117, 'Raymond', '1959-03-27', false, 27);
INSERT INTO prénom VALUES (117, 'Henri');
INSERT INTO professeur VALUES (117, 'HRD');

INSERT INTO personne VALUES(118, 'Trudeau', '1970-12-13', false, 21);
INSERT INTO prénom VALUES (118, 'Christiane');
INSERT INTO professeur VALUES (118, 'CTU');

INSERT INTO personne VALUES(119, 'Cloutier', '1972-08-08', false, 35);
INSERT INTO prénom VALUES (119, 'Didier');
INSERT INTO professeur VALUES (119, 'DCR');

INSERT INTO personne VALUES(120, 'Simard', '1977-10-12', false, 51);
INSERT INTO prénom VALUES (120, 'Nicolas');
INSERT INTO professeur VALUES (120, 'NSD');

INSERT INTO personne VALUES(121, 'Brousseau', '1959-04-03', false, 10);
INSERT INTO prénom VALUES (121, 'Alexandre');
INSERT INTO professeur VALUES (121, 'ABU');

INSERT INTO personne VALUES(122, 'Alphonse', '1972-09-08', false, 27);
INSERT INTO prénom VALUES (122, 'Robert');
INSERT INTO professeur VALUES (122, 'RAE');

INSERT INTO personne VALUES(123, 'Joly', '1983-02-19', false, 34);
INSERT INTO prénom VALUES (123, 'Gaetan');
INSERT INTO professeur VALUES (123, 'GJY');

INSERT INTO personne VALUES(124, 'Poirier', '1969-07-02', false, 23);
INSERT INTO prénom VALUES (124, 'Lucas');
INSERT INTO professeur VALUES (124, 'LPR');

INSERT INTO personne VALUES(125, 'Caisse', '1982-09-30', false, 45);
INSERT INTO prénom VALUES (125, 'Patrick');
INSERT INTO professeur VALUES (125, 'PCE');

INSERT INTO personne VALUES(126, 'Émond', '1985-05-23', false, 53);
INSERT INTO prénom VALUES (126, 'Sébastien');
INSERT INTO professeur VALUES (126, 'SED');

INSERT INTO personne VALUES(127, 'Labelle', '1981-09-28', false, 42);
INSERT INTO prénom VALUES (127, 'Adrien');
INSERT INTO professeur VALUES (127, 'ADE');

INSERT INTO personne VALUES(128, 'Pinette', '1983-04-13', false, 12);
INSERT INTO prénom VALUES (128, 'David');
INSERT INTO professeur VALUES (128, 'DPE');

INSERT INTO personne VALUES(129, 'Giroux', '1971-12-09', false, 21);
INSERT INTO prénom VALUES (129, 'Alfred');
INSERT INTO professeur VALUES (129, 'AGX');

INSERT INTO personne VALUES(130, 'Bernard', '1965-01-01', false, 34);
INSERT INTO prénom VALUES (130, 'Christian');
INSERT INTO professeur VALUES (130, 'CBD');

INSERT INTO personne VALUES(131, 'Valiant', '1969-03-14', false, 15);
INSERT INTO prénom VALUES (131, 'Gabriel');
INSERT INTO professeur VALUES (131, 'GVT');

INSERT INTO personne VALUES(132, 'Desruisseaux', '1974-02-14', false, 46);
INSERT INTO prénom VALUES (132, 'Thierry');
INSERT INTO professeur VALUES (132, 'TDX');

-- Semestres
-- 2021
INSERT INTO semestre VALUES (2021, 1, 38, 6);
INSERT INTO semestre VALUES (2021, 2, 8, 27);

--2020
INSERT INTO semestre VALUES (2020, 1, 38, 6);
INSERT INTO semestre VALUES (2020, 2, 8, 27);

-- Plage horaire
INSERT INTO plagehoraire VALUES (0, '08:30', '09:15');
INSERT INTO plagehoraire VALUES (1, '09:15', '10:00');
INSERT INTO plagehoraire VALUES (2, '10:25', '11:10');
INSERT INTO plagehoraire VALUES (3, '11:15', '12:00');
INSERT INTO plagehoraire VALUES (4, '12:00', '12:45');
INSERT INTO plagehoraire VALUES (5, '13:15', '14:00');
INSERT INTO plagehoraire VALUES (6, '14:00', '14:45');
INSERT INTO plagehoraire VALUES (7, '14:55', '15:40');
INSERT INTO plagehoraire VALUES (8, '15:45', '16:30');
INSERT INTO plagehoraire VALUES (9, '16:35', '17:20');
INSERT INTO plagehoraire VALUES (10, '17:20', '18:05');

-- Bâtiment
INSERT INTO bâtiment VALUES ('Cheseaux', 200);
INSERT INTO bâtiment VALUES ('St-Roch', 0);
INSERT INTO bâtiment VALUES ('Y-Parc', 0);

-- Salle

-- Cheseaux
-- Etage A
INSERT INTO salle VALUES (101, 'Cheseaux');
INSERT INTO salle VALUES (105, 'Cheseaux');
INSERT INTO salle VALUES (106, 'Cheseaux');
INSERT INTO salle VALUES (107, 'Cheseaux');
INSERT INTO salle VALUES (109, 'Cheseaux');

-- Etage B
INSERT INTO salle VALUES (201, 'Cheseaux');
INSERT INTO salle VALUES (203, 'Cheseaux');
INSERT INTO salle VALUES (205, 'Cheseaux');
INSERT INTO salle VALUES (208, 'Cheseaux');
INSERT INTO salle VALUES (210, 'Cheseaux');
INSERT INTO salle VALUES (223, 'Cheseaux');
INSERT INTO salle VALUES (226, 'Cheseaux');

-- Etage C
INSERT INTO salle VALUES (305, 'Cheseaux');
INSERT INTO salle VALUES (306, 'Cheseaux');
INSERT INTO salle VALUES (323, 'Cheseaux');
INSERT INTO salle VALUES (333, 'Cheseaux');
INSERT INTO salle VALUES (337, 'Cheseaux');
INSERT INTO salle VALUES (338, 'Cheseaux');
INSERT INTO salle VALUES (341, 'Cheseaux');

-- Etage D
INSERT INTO salle VALUES (401, 'Cheseaux');
INSERT INTO salle VALUES (405, 'Cheseaux');
INSERT INTO salle VALUES (407, 'Cheseaux');
INSERT INTO salle VALUES (410, 'Cheseaux');
INSERT INTO salle VALUES (451, 'Cheseaux');

-- Etage F
INSERT INTO salle VALUES (601, 'Cheseaux');

-- Etage G
INSERT INTO salle VALUES (701, 'Cheseaux');
INSERT INTO salle VALUES (702, 'Cheseaux');
INSERT INTO salle VALUES (703, 'Cheseaux');
INSERT INTO salle VALUES (704, 'Cheseaux');
INSERT INTO salle VALUES (705, 'Cheseaux');

-- Etage H
INSERT INTO salle VALUES (801, 'Cheseaux');
INSERT INTO salle VALUES (802, 'Cheseaux');
INSERT INTO salle VALUES (803, 'Cheseaux');
INSERT INTO salle VALUES (804, 'Cheseaux');
INSERT INTO salle VALUES (805, 'Cheseaux');

-- Etage H
INSERT INTO salle VALUES (901, 'Cheseaux');
INSERT INTO salle VALUES (902, 'Cheseaux');
INSERT INTO salle VALUES (903, 'Cheseaux');
INSERT INTO salle VALUES (904, 'Cheseaux');
INSERT INTO salle VALUES (905, 'Cheseaux');
INSERT INTO salle VALUES (906, 'Cheseaux');

-- Etage I
INSERT INTO salle VALUES (1001, 'Cheseaux');
INSERT INTO salle VALUES (1002, 'Cheseaux');
INSERT INTO salle VALUES (1003, 'Cheseaux');
INSERT INTO salle VALUES (1004, 'Cheseaux');

-- St-Roch
INSERT INTO salle VALUES (101, 'St-Roch');
INSERT INTO salle VALUES (105, 'St-Roch');
INSERT INTO salle VALUES (107, 'St-Roch');
INSERT INTO salle VALUES (109, 'St-Roch');

-- Y-Parc
INSERT INTO salle VALUES (101, 'Y-Parc');
INSERT INTO salle VALUES (105, 'Y-Parc');
INSERT INTO salle VALUES (107, 'Y-Parc');
INSERT INTO salle VALUES (109, 'Y-Parc');

-- Type Leçon
INSERT INTO typeleçon VALUES('Cours');
INSERT INTO typeleçon VALUES('Labo');

-- Type Test
INSERT INTO typetest VALUES('TE', 0.5);
INSERT INTO typetest VALUES('TP', 0.2);

-- Statut
INSERT INTO statut VALUES('Réussite');
INSERT INTO statut VALUES('Echec');
INSERT INTO statut VALUES('Abandon');
INSERT INTO statut VALUES('En cours');

-- Il faut désactiver temporairement la contrainte pour pouvoir créer des semestres dans le passé
-- Il faut modifier la contrainte CK_Semestre_semaineFin afin de vérifier que si la sem de début + durée > 52 alors
-- la semaine de fin est inférieure

-- 2021

-- Semestre 1
-- 1ere année
INSERT INTO cours VALUES(0, 'MAD', 38, 21, 1, 1, 2021);
INSERT INTO cours VALUES(1, 'PRG1', 38, 21, 1, 1, 2021);
INSERT INTO cours VALUES(2, 'MAT1', 38, 21, 1, 1, 2021);
INSERT INTO cours VALUES(3, 'EXP', 38, 21, 1, 1, 2021);
INSERT INTO cours VALUES(4, 'RXI', 38, 21, 1, 1, 2021);
INSERT INTO cours VALUES(5, 'SYL', 38, 21, 1, 1, 2021);

INSERT INTO cours VALUES(41, 'MAD', 38, 21, 1, 1, 2020);
INSERT INTO cours VALUES(42, 'PRG1', 38, 21, 1, 1, 2020);
INSERT INTO cours VALUES(43, 'MAT1', 38, 21, 1, 1, 2020);
INSERT INTO cours VALUES(44, 'EXP', 38, 21, 1, 1, 2020);
INSERT INTO cours VALUES(45, 'RXI', 38, 21, 1, 1, 2020);
INSERT INTO cours VALUES(46, 'SYL', 38, 21, 1, 1, 2020);


-- 2eme année
INSERT INTO cours VALUES(6, 'API', 38, 21, 2, 1, 2021);
INSERT INTO cours VALUES(7, 'SYE', 38, 21, 2, 1, 2021);
INSERT INTO cours VALUES(8, 'MAT3', 38, 21, 2, 1, 2021);
INSERT INTO cours VALUES(9, 'PCO', 38, 21, 2, 1, 2021);
INSERT INTO cours VALUES(10, 'BDR', 38, 21, 2, 1, 2021);
INSERT INTO cours VALUES(11, 'PST', 38, 21, 2, 1, 2021);
INSERT INTO cours VALUES(12, 'POO', 38, 21, 2, 1, 2021);

-- 3eme année
INSERT INTO cours VALUES(13, 'IHM', 38, 21, 3, 1, 2021);
INSERT INTO cours VALUES(14, 'GET', 38, 21, 3, 1, 2021);
INSERT INTO cours VALUES(15, 'AMT', 38, 21, 3, 1, 2021);
INSERT INTO cours VALUES(16, 'WEB', 38, 21, 3, 1, 2021);
INSERT INTO cours VALUES(17, 'MAC', 38, 21, 3, 1, 2021);
INSERT INTO cours VALUES(18, 'PRR', 38, 21, 3, 1, 2021);
INSERT INTO cours VALUES(19, 'SYM', 38, 21, 3, 1, 2021);

-- Semestre 2
-- 1ere année
INSERT INTO cours VALUES(20, 'ARO', 8, 20, 1, 2, 2021);
INSERT INTO cours VALUES(21, 'ISI', 8, 20, 1, 2, 2021);
INSERT INTO cours VALUES(22, 'ASD', 8, 20, 1, 2, 2021);
INSERT INTO cours VALUES(23, 'MAT2', 8, 20, 1, 2, 2021);
INSERT INTO cours VALUES(24, 'ISD', 8, 20, 1, 2, 2021);
INSERT INTO cours VALUES(25, 'ANG', 8, 20, 1, 2, 2021);
INSERT INTO cours VALUES(26, 'PRG2', 8, 20, 1, 2, 2021);

-- 2ème année
INSERT INTO cours VALUES(27, 'CLD', 8, 20, 2, 2, 2021);
INSERT INTO cours VALUES(28, 'MAC', 8, 20, 2, 2, 2021);
INSERT INTO cours VALUES(29, 'ARN', 8, 20, 2, 2, 2021);
INSERT INTO cours VALUES(30, 'GRE', 8, 20, 2, 2, 2021);
INSERT INTO cours VALUES(31, 'MCR', 8, 20, 2, 2, 2021);
INSERT INTO cours VALUES(32, 'PLP', 8, 20, 2, 2, 2021);
INSERT INTO cours VALUES(33, 'POA', 8, 20, 2, 2, 2021);
INSERT INTO cours VALUES(34, 'DIL', 8, 20, 2, 2, 2021);

--3ème année
INSERT INTO cours VALUES(35, 'SEC', 8, 20, 3, 2, 2021);
INSERT INTO cours VALUES(36, 'SCALA', 8, 20, 3, 2, 2021);
INSERT INTO cours VALUES(37, 'MLG', 8, 20, 3, 2, 2021);
INSERT INTO cours VALUES(38, 'VTK', 8, 20, 3, 2, 2021);
INSERT INTO cours VALUES(39, 'CLD', 8, 20, 3, 2, 2021);
INSERT INTO cours VALUES(40, 'PDG', 8, 20, 3, 2, 2021);

INSERT INTO cours VALUES(47, 'AMT', 8, 20, 3, 1, 2021);
INSERT INTO cours VALUES(48, 'AIT', 8, 20, 3, 1, 2021);
INSERT INTO cours VALUES(49, 'GET', 8, 20, 3, 1, 2021);
INSERT INTO cours VALUES(50, 'SYM', 8, 20, 3, 1, 2021);
INSERT INTO cours VALUES(51, 'WEB', 8, 20, 3, 1, 2021);
INSERT INTO cours VALUES(52, 'AST', 8, 20, 3, 1, 2021);
INSERT INTO cours VALUES(53, 'STI', 8, 20, 3, 1, 2021);
INSERT INTO cours VALUES(54, 'GRX', 8, 20, 3, 1, 2021);
INSERT INTO cours VALUES(55, 'IHM', 8, 20, 3, 1, 2021);
INSERT INTO cours VALUES(56, 'MAC', 8, 20, 3, 1, 2021);
INSERT INTO cours VALUES(57, 'PDG', 8, 20, 3, 1, 2021);
INSERT INTO cours VALUES(58, 'PRR', 8, 20, 3, 1, 2021);

-- Leçon

-------------------------------------
-- 3 Classes de 1ère année 2021 - S1
-------------------------------------

-- Classe 1 (Hugo Ducommun)
-- Lundi
INSERT INTO leçon VALUES(0, 1, 2, 2, 'Cours', 903, 'Cheseaux', 2, 1);
INSERT INTO leçon VALUES(1, 2, 3, 5, 'Cours', 105, 'Cheseaux', 2, 1);
INSERT INTO leçon VALUES(2, 3, 4, 7, 'Cours', 105, 'Cheseaux', 2, 1);
INSERT INTO leçon VALUES(3, 4, 5, 9, 'Labo', 205, 'Cheseaux', 2, 1);

-- Mardi
INSERT INTO leçon VALUES(4, 1, 2, 0, 'Labo', 703, 'Cheseaux', 2, 2);
INSERT INTO leçon VALUES(5, 0, 6, 2, 'Cours', 105, 'Cheseaux', 2, 2);

-- Mercredi
INSERT INTO leçon VALUES(6, 1, 2, 0, 'Cours', 901, 'Cheseaux', 2, 3);
INSERT INTO leçon VALUES(7, 5, 1, 2, 'Cours', 109, 'Cheseaux', 2, 3);
INSERT INTO leçon VALUES(8, 5, 1, 5, 'Cours', 223, 'Cheseaux', 2, 3);

-- Jeudi
INSERT INTO leçon VALUES(9, 1, 2, 2, 'Cours', 201, 'Cheseaux', 2, 4);
INSERT INTO leçon VALUES(10, 0, 6, 5, 'Cours', 804, 'Cheseaux', 2, 4);
INSERT INTO leçon VALUES(11, 2, 3, 7, 'Cours', 804, 'Cheseaux', 2, 4);
INSERT INTO leçon VALUES(12, 4, 5, 9, 'Cours', 323, 'Cheseaux', 2, 4);

-- Vendredi
INSERT INTO leçon VALUES(13, 2, 3, 0, 'Cours', 704, 'Cheseaux', 2, 5);
INSERT INTO leçon VALUES(14, 1, 2, 2, 'Cours', 704, 'Cheseaux', 2, 5);
INSERT INTO leçon VALUES(15, 1, 2, 5, 'Cours', 223, 'Cheseaux', 2, 5);

-- Classe 2 (Delay Benoît)
-- Lundi
INSERT INTO leçon VALUES(16, 5, 107, 0, 'Cours', 223, 'Cheseaux', 2, 1);
INSERT INTO leçon VALUES(17, 2, 108, 2, 'Cours', 223, 'Cheseaux', 2, 1);
INSERT INTO leçon VALUES(18, 3, 4, 5, 'Cours', 223, 'Cheseaux', 2, 1);
INSERT INTO leçon VALUES(19, 4, 5, 7, 'Cours', 205, 'Cheseaux', 2, 1);

-- Mardi
INSERT INTO leçon VALUES(20, 1, 108, 0, 'Cours', 601, 'Cheseaux', 2, 2);
INSERT INTO leçon VALUES(21, 2, 109, 2, 'Cours', 601, 'Cheseaux', 2, 2);
INSERT INTO leçon VALUES(22, 0, 110, 5, 'Cours', 804, 'Cheseaux', 2, 2);

-- Mercredi
INSERT INTO leçon VALUES(23, 1, 108, 2, 'Cours', 1004, 'Cheseaux', 2, 3);
INSERT INTO leçon VALUES(24, 1, 108, 5, 'Cours', 1004, 'Cheseaux', 2, 3);
INSERT INTO leçon VALUES(25, 2, 109, 7, 'Cours', 1004, 'Cheseaux', 2, 3);

-- Jeudi
INSERT INTO leçon VALUES(26, 5, 107, 2, 'Cours', 107, 'Cheseaux', 2, 4);
INSERT INTO leçon VALUES(27, 2, 109, 5, 'Cours', 704, 'Cheseaux', 2, 4);
INSERT INTO leçon VALUES(28, 0, 110, 7, 'Cours', 704, 'Cheseaux', 2, 4);
-- meme que (Delay Benoit) INSERT INTO leçon VALUES(29, 4, 5, 9, 'Cours', 323, 'Cheseaux', 2, 4);

-- Vendredi
INSERT INTO leçon VALUES(30, 1, 108, 0, 'Cours', 906, 'Cheseaux', 2, 5);
INSERT INTO leçon VALUES(31, 1, 108, 2, 'Cours', 906, 'Cheseaux', 2, 5);

-- Classe 3 (Bouattit Nikola)
-- Lundi
-- meme que (Delay Benoit) INSERT INTO leçon VALUES(32, 5, 107, 0, 'Cours', 223, 'Cheseaux', 2, 1);
INSERT INTO leçon VALUES(33, 2, 109, 2, 'Cours', 701, 'Cheseaux', 2, 1);
INSERT INTO leçon VALUES(34, 5, 107, 5, 'Cours', 109, 'Cheseaux', 2, 1);
INSERT INTO leçon VALUES(35, 2, 111, 7, 'Cours', 106, 'Cheseaux', 2, 1);

-- Mardi
INSERT INTO leçon VALUES(36, 3, 4, 0, 'Cours', 323, 'Cheseaux', 2, 2);
INSERT INTO leçon VALUES(37, 1, 111, 2, 'Cours', 323, 'Cheseaux', 2, 2);
INSERT INTO leçon VALUES(38, 2, 109, 5, 'Cours', 701, 'Cheseaux', 2, 2);
INSERT INTO leçon VALUES(39, 4, 5, 7, 'Cours', 205, 'Cheseaux', 2, 2);
INSERT INTO leçon VALUES(40, 0, 110, 9, 'Cours', 701, 'Cheseaux', 2, 2);

-- Mercredi
INSERT INTO leçon VALUES(41, 1, 111, 2, 'Cours', 223, 'Cheseaux', 2, 3);
INSERT INTO leçon VALUES(42, 2, 109, 5, 'Cours', 701, 'Cheseaux', 2, 3);

-- Jeudi
INSERT INTO leçon VALUES(43, 1, 111, 2, 'Cours', 803, 'Cheseaux', 2, 4);
INSERT INTO leçon VALUES(44, 0, 110, 5, 'Cours', 801, 'Cheseaux', 2, 4);

-- Vendredi
INSERT INTO leçon VALUES(43, 4, 5, 2, 'Cours', 223, 'Cheseaux', 2, 5);
INSERT INTO leçon VALUES(44, 1, 111, 5, 'Cours', 223, 'Cheseaux', 2, 5);
INSERT INTO leçon VALUES(45, 1, 111, 5, 'Cours', 323, 'Cheseaux', 2, 5);

-------------------------------------
-- 3 Classes de 1ère année 2020 - S1
-------------------------------------

-- Classe 1 (Louis Hadrien)
-- Lundi
INSERT INTO leçon VALUES(46, 42, 2, 1, 'Cours', 701, 'Cheseaux', 2, 1);
INSERT INTO leçon VALUES(47, 44, 4, 3, 'Cours', 701, 'Cheseaux', 2, 1);
INSERT INTO leçon VALUES(48, 43, 109, 6, 'Cours', 341, 'Cheseaux', 2, 1);

-- Mardi
INSERT INTO leçon VALUES(49, 42, 2, 0, 'Cours', 702, 'Cheseaux', 2, 2);
INSERT INTO leçon VALUES(50, 42, 2, 2, 'Cours', 702, 'Cheseaux', 2, 2);
INSERT INTO leçon VALUES(51, 46, 107, 5, 'Cours', 601, 'Cheseaux', 2, 2);

-- Mercredi
INSERT INTO leçon VALUES(52, 41, 112, 0, 'Cours', 702, 'Cheseaux', 2, 3);
INSERT INTO leçon VALUES(53, 46, 107, 2, 'Cours', 107, 'Cheseaux', 2, 3);
INSERT INTO leçon VALUES(54, 43, 109, 5, 'Cours', 341, 'Cheseaux', 2, 3);

-- Jeudi
INSERT INTO leçon VALUES(55, 42, 2, 0, 'Cours', 905, 'Cheseaux', 2, 4);
INSERT INTO leçon VALUES(56, 42, 2, 2, 'Cours', 905, 'Cheseaux', 2, 4);
INSERT INTO leçon VALUES(57, 41, 112, 5, 'Cours', 801, 'Cheseaux', 2, 4);
INSERT INTO leçon VALUES(58, 43, 109, 7, 'Cours', 801, 'Cheseaux', 2, 4);

-- Vendredi
INSERT INTO leçon VALUES(59, 45, 113, 0, 'Cours', 223, 'Cheseaux', 2, 5);
INSERT INTO leçon VALUES(60, 45, 113, 2, 'Cours', 205, 'Cheseaux', 2, 5);
INSERT INTO leçon VALUES(61, 42, 2, 5, 'Cours', 223, 'Cheseaux', 2, 5);

-- Classe 2 (Tobie Praz)
-- Lundi
INSERT INTO leçon VALUES(62, 42, 111, 0, 'Cours', 901, 'Cheseaux', 2, 1);
INSERT INTO leçon VALUES(63, 43, 6, 2, 'Cours', 901, 'Cheseaux', 2, 1);

-- Mardi
INSERT INTO leçon VALUES(64, 42, 111, 0, 'Cours', 901, 'Cheseaux', 2, 2);
INSERT INTO leçon VALUES(65, 43, 112, 2, 'Cours', 901, 'Cheseaux', 2, 2);
-- (voir cours 51) INSERT INTO leçon VALUES(66, 46, 107, 5, 'Cours', 601, 'Cheseaux', 2, 2);

-- Mercredi
INSERT INTO leçon VALUES(67, 46, 107, 0, 'Cours', 107, 'Cheseaux', 2, 3);
INSERT INTO leçon VALUES(68, 42, 111, 2, 'Cours', 702, 'Cheseaux', 2, 3);
INSERT INTO leçon VALUES(69, 42, 111, 5, 'Cours', 801, 'Cheseaux', 2, 3);
INSERT INTO leçon VALUES(70, 41, 112, 7, 'Cours', 801, 'Cheseaux', 2, 3);

-- Jeudi
INSERT INTO leçon VALUES(71, 42, 111, 0, 'Cours', 704, 'Cheseaux', 2, 4);
INSERT INTO leçon VALUES(72, 44, 4, 2, 'Cours', 704, 'Cheseaux', 2, 4);
INSERT INTO leçon VALUES(73, 43, 6, 5, 'Cours', 337, 'Cheseaux', 2, 4);
INSERT INTO leçon VALUES(74, 42, 111, 7, 'Cours', 337, 'Cheseaux', 2, 4);

-- Vendredi
-- (voir cours 59) INSERT INTO leçon VALUES(75, 45, 113, 0, 'Cours', 223, 'Cheseaux', 2, 5);
INSERT INTO leçon VALUES(76, 43, 6, 2, 'Cours', 801, 'Cheseaux', 2, 5);
INSERT INTO leçon VALUES(77, 45, 113, 5, 'Cours', 205, 'Cheseaux', 2, 5);

-- Classe 3 (Olivier D'Ancona)
-- Lundi
INSERT INTO leçon VALUES(78, 43, 109, 2, 'Cours', 906, 'Cheseaux', 2, 1);
INSERT INTO leçon VALUES(79, 46, 114, 5, 'Cours', 109, 'Cheseaux', 2, 1);
INSERT INTO leçon VALUES(80, 45, 5, 7, 'Cours', 223, 'Cheseaux', 2, 1);
INSERT INTO leçon VALUES(81, 45, 5, 9, 'Cours', 201, 'Cheseaux', 2, 1);

-- Mardi
INSERT INTO leçon VALUES(82, 43, 109, 0, 'Cours', 337, 'Cheseaux', 2, 2);
INSERT INTO leçon VALUES(83, 42, 115, 2, 'Cours', 337, 'Cheseaux', 2, 2);
INSERT INTO leçon VALUES(84, 41, 112, 5, 'Cours', 1004, 'Cheseaux', 2, 2);
INSERT INTO leçon VALUES(85, 44, 4, 7, 'Cours', 1004, 'Cheseaux', 2, 2);

-- Mercredi
INSERT INTO leçon VALUES(86, 42, 115, 0, 'Cours', 701, 'Cheseaux', 2, 3);
INSERT INTO leçon VALUES(87, 42, 115, 2, 'Cours', 701, 'Cheseaux', 2, 3);
INSERT INTO leçon VALUES(88, 46, 114, 5, 'Cours', 601, 'Cheseaux', 2, 3);
INSERT INTO leçon VALUES(89, 43, 109, 7, 'Cours', 341, 'Cheseaux', 2, 3);

-- Jeudi
INSERT INTO leçon VALUES(90, 41, 112, 2, 'Cours', 333, 'Cheseaux', 2, 4);
INSERT INTO leçon VALUES(91, 42, 115, 5, 'Cours', 802, 'Cheseaux', 2, 4);

-- Vendredi
INSERT INTO leçon VALUES(92, 42, 115, 0, 'Cours', 803, 'Cheseaux', 2, 5);
INSERT INTO leçon VALUES(93, 42, 115, 2, 'Cours', 803, 'Cheseaux', 2, 5);

-------------------------------------
-- 3 Classes de 1ère année 2020 - S2
-------------------------------------

-- Classe 1 (Louis Hadrien)

-- Lundi
INSERT INTO leçon VALUES(94, 20, 119, 0, 'Cours', 223, 'Cheseaux', 2, 1);
INSERT INTO leçon VALUES(95, 20, 119, 2, 'Cours', 107, 'Cheseaux', 2, 1);
INSERT INTO leçon VALUES(96, 21, 116, 7, 'Cours', 601, 'Cheseaux', 2, 1);
INSERT INTO leçon VALUES(97, 22, 115, 9, 'Cours', 901, 'Cheseaux', 2, 1);

-- Mardi
INSERT INTO leçon VALUES(98, 23, 6, 0, 'Cours', 801, 'Cheseaux', 2, 2);
INSERT INTO leçon VALUES(99, 26, 2, 2, 'Cours', 701, 'Cheseaux', 2, 2);
INSERT INTO leçon VALUES(100, 22, 115, 5, 'Cours', 323, 'Cheseaux', 2, 2);
INSERT INTO leçon VALUES(101, 22, 115, 7, 'Cours', 101, 'Cheseaux', 2, 2);

-- Mercredi
INSERT INTO leçon VALUES(102, 24, 117, 2, 'Cours', 341, 'Cheseaux', 2, 3);
INSERT INTO leçon VALUES(103, 24, 117, 5, 'Cours', 323, 'Cheseaux', 2, 3);
INSERT INTO leçon VALUES(104, 23, 6, 7, 'Cours', 701, 'Cheseaux', 2, 3);

-- Jeudi
INSERT INTO leçon VALUES(105, 26, 2, 2, 'Cours', 223, 'Cheseaux', 2, 4);
INSERT INTO leçon VALUES(106, 25, 118, 4, 'Cours', 802, 'Cheseaux', 3, 4);
INSERT INTO leçon VALUES(107, 23, 6, 7, 'Cours', 801, 'Cheseaux', 2, 4);

-- Vendredi
INSERT INTO leçon VALUES(108, 22, 115, 5, 'Cours', 601, 'Cheseaux', 2, 5);
INSERT INTO leçon VALUES(109, 21, 116, 7, 'Cours', 801, 'Cheseaux', 2, 5);

-- Classe 2 (Tobie Praz)
-- (meme cours que hadrien)


-- Classe 3 (Olivier D'ancona)
-- Lundi
INSERT INTO leçon VALUES(110, 23, 109, 0, 'Cours', 223, 'Cheseaux', 2, 1);
-- (ISI - meme cours que Hadrien)
-- (ASD - meme cours que hadrien)

-- Mardi
-- (PRG2 - meme cours que hadrien)
-- (ASD - meme cours que hadrien)
-- (ASD - meme cours que hadrien)

-- Mercredi
-- meme que Hadrien INSERT INTO leçon VALUES(111, 24, 117, 2, 'Cours', 341, 'Cheseaux', 2, 3);
INSERT INTO leçon VALUES(112, 20, 114, 5, 'Cours', 323, 'Cheseaux', 2, 3);
-- (ISD - meme cours que hadrien)
INSERT INTO leçon VALUES(113, 23, 109, 7, 'Cours', 701, 'Cheseaux', 2, 3);

-- Jeudi
-- (PRG2 - meme cours que hadrien)
INSERT INTO leçon VALUES(114, 25, 120, 4, 'Cours', 802, 'Cheseaux', 3, 4);
INSERT INTO leçon VALUES(115, 23, 109, 7, 'Cours', 801, 'Cheseaux', 2, 4);

-- Vendredi
INSERT INTO leçon VALUES(116, 21, 116, 5, 'Cours', 601, 'Cheseaux', 2, 5);
INSERT INTO leçon VALUES(117, 20, 114, 7, 'Cours', 801, 'Cheseaux', 2, 5);
-- (ASD - meme cours que hadrien)


-------------------------------------
-- 3 Classes de 1ère année 2021 - S1
-------------------------------------

-- Hadrien Louis
-- Lundi
INSERT INTO leçon VALUES(118, 7, 121, 0, 'Cours', 701, 'Cheseaux', 2, 1);
INSERT INTO leçon VALUES(119, 8, 110, 2, 'Cours', 901, 'Cheseaux', 2, 1);
INSERT INTO leçon VALUES(120, 9, 122, 5, 'Cours', 323, 'Cheseaux', 2, 1);
INSERT INTO leçon VALUES(121, 10, 2, 7, 'Cours', 323, 'Cheseaux', 2, 1);

-- Mardi
INSERT INTO leçon VALUES(122, 9, 122, 0, 'Cours', 201, 'Cheseaux', 2, 2);
INSERT INTO leçon VALUES(123, 10, 2, 2, 'Cours', 223, 'Cheseaux', 2, 2);
INSERT INTO leçon VALUES(124, 11, 123, 5, 'Cours', 1004, 'Cheseaux', 2, 2);

-- Mercredi
INSERT INTO leçon VALUES(125, 6, 113, 0, 'Cours', 323, 'Cheseaux', 2, 3);
INSERT INTO leçon VALUES(126, 6, 113, 2, 'Cours', 333, 'Cheseaux', 2, 3);
INSERT INTO leçon VALUES(127, 12, 124, 5, 'Cours', 802, 'Cheseaux', 2, 3);

-- Jeudi
INSERT INTO leçon VALUES(128, 10, 2, 0, 'Cours', 223, 'Cheseaux', 2, 4);
INSERT INTO leçon VALUES(129, 7, 121, 2, 'Cours', 105, 'Cheseaux', 2, 4);
INSERT INTO leçon VALUES(130, 12, 124, 5, 'Cours', 802, 'Cheseaux', 2, 4);
INSERT INTO leçon VALUES(131, 12, 124, 7, 'Cours', 802, 'Cheseaux', 2, 4);

-- Vendredi
INSERT INTO leçon VALUES(132, 8, 110, 1, 'Cours', 1004, 'Cheseaux', 2, 5);
INSERT INTO leçon VALUES(133, 11, 123, 5, 'Cours', 801, 'Cheseaux', 2, 5);

-- Classe 2 (Tobie praz)
-- meme cours que Hadrien

-- Classe 3 (Olivier D'ancona)
-- Lundi
INSERT INTO leçon VALUES(134, 7, 1, 0, 'Cours', 901, 'Cheseaux', 2, 1);
INSERT INTO leçon VALUES(135, 8, 6, 2, 'Cours', 702, 'Cheseaux', 2, 1);
-- PCO (meme cours que hadrien) INSERT INTO leçon VALUES(136, 9, 122, 5, 'Cours', 323, 'Cheseaux', 2, 1);

-- Mardi
INSERT INTO leçon VALUES(136, 12, 122, 0, 'Cours', 1004, 'Cheseaux', 2, 2);
INSERT INTO leçon VALUES(137, 11, 125, 2, 'Cours', 801, 'Cheseaux', 2, 2);
INSERT INTO leçon VALUES(139, 10, 126, 5, 'Cours', 323, 'Cheseaux', 2, 2);
INSERT INTO leçon VALUES(140, 10, 2, 7, 'Cours', 337, 'Cheseaux', 2, 2);
INSERT INTO leçon VALUES(141, 7, 2, 9, 'Cours', 105, 'Cheseaux', 2, 2);

-- Mercredi
-- API ( meme cours que hadrien) INSERT INTO leçon VALUES(142, 6, 113, 0, 'Cours', 323, 'Cheseaux', 2, 3);
INSERT INTO leçon VALUES(143, 10, 2, 2, 'Cours', 323, 'Cheseaux', 2, 3);
INSERT INTO leçon VALUES(144, 8, 6, 5, 'Cours', 704, 'Cheseaux', 2, 3);

-- Jeudi
INSERT INTO leçon VALUES(145, 6, 113, 2, 'Cours', 223, 'Cheseaux', 2, 4);
INSERT INTO leçon VALUES(146, 9, 122, 5, 'Cours', 105, 'Cheseaux', 2, 4);

-- Vendredi
INSERT INTO leçon VALUES(147, 12, 125, 0, 'Cours', 902, 'Cheseaux', 2, 5);
INSERT INTO leçon VALUES(148, 12, 125, 2, 'Cours', 902, 'Cheseaux', 2, 5);
INSERT INTO leçon VALUES(149, 11, 126, 5, 'Cours', 701, 'Cheseaux', 2, 5);

-------------------------------------
-- 2 Classes de 3ème année 2021 - S1
-------------------------------------

-- Classe 1

-- Leonard Besseau
-- Lundi
INSERT INTO leçon VALUES(150, 47, 127, 5, 'Cours', 705, 'Cheseaux', 3, 1);
INSERT INTO leçon VALUES(151, 48, 128, 9, 'Cours', 901, 'Cheseaux', 2, 1);

-- Mardi
INSERT INTO leçon VALUES(152, 50, 130, 5, 'Cours', 223, 'Cheseaux', 2, 2);
INSERT INTO leçon VALUES(153, 49, 4, 7, 'Cours', 341, 'Cheseaux', 2, 2);

-- Mercredi
INSERT INTO leçon VALUES(154, 50, 130, 2, 'Cours', 601, 'Cheseaux', 2, 3);
INSERT INTO leçon VALUES(155, 51, 131, 5, 'Cours', 601, 'Cheseaux', 3, 3);
INSERT INTO leçon VALUES(156, 53, 129, 10, 'Cours', 223, 'Cheseaux', 1, 3);

-- Jeudi
INSERT INTO leçon VALUES(157, 52, 132, 1, 'Cours', 802, 'Cheseaux', 3, 4);
INSERT INTO leçon VALUES(158, 53, 129, 5, 'Cours', 223, 'Cheseaux', 2, 4);
INSERT INTO leçon VALUES(159, 54, 5, 7, 'Cours', 205, 'Cheseaux', 2, 4);
INSERT INTO leçon VALUES(160, 48, 128, 9, 'Cours', 223, 'Cheseaux', 2, 4);

-- Vendredi
INSERT INTO leçon VALUES(161, 51, 131, 1, 'Cours', 323, 'Cheseaux', 3, 5);
INSERT INTO leçon VALUES(162, 52, 132, 5, 'Cours', 906, 'Cheseaux', 2, 5);
INSERT INTO leçon VALUES(163, 47, 127, 7, 'Cours', 601, 'Cheseaux', 3, 5);

-- Classe 2

-- Alec Berney
-- Lundi
INSERT INTO leçon VALUES(150, 47, 127, 5, 'Cours', 705, 'Cheseaux', 3, 1);
INSERT INTO leçon VALUES(151, 48, 128, 9, 'Cours', 901, 'Cheseaux', 2, 1);
INSERT INTO leçon VALUES(151, 48, 128, 9, 'Cours', 901, 'Cheseaux', 2, 1);
INSERT INTO leçon VALUES(151, 48, 128, 9, 'Cours', 901, 'Cheseaux', 2, 1);

-- Mardi
INSERT INTO leçon VALUES(152, 50, 130, 5, 'Cours', 223, 'Cheseaux', 2, 2);
INSERT INTO leçon VALUES(153, 49, 4, 7, 'Cours', 341, 'Cheseaux', 2, 2);

-- Mercredi
INSERT INTO leçon VALUES(154, 50, 130, 2, 'Cours', 601, 'Cheseaux', 2, 3);
INSERT INTO leçon VALUES(155, 51, 131, 5, 'Cours', 601, 'Cheseaux', 3, 3);
INSERT INTO leçon VALUES(156, 53, 129, 10, 'Cours', 223, 'Cheseaux', 1, 3);

-- Jeudi
INSERT INTO leçon VALUES(157, 52, 132, 1, 'Cours', 802, 'Cheseaux', 3, 4);
INSERT INTO leçon VALUES(158, 53, 129, 5, 'Cours', 223, 'Cheseaux', 2, 4);
INSERT INTO leçon VALUES(159, 54, 5, 7, 'Cours', 205, 'Cheseaux', 2, 4);

-- Vendredi
INSERT INTO leçon VALUES(161, 51, 131, 1, 'Cours', 323, 'Cheseaux', 3, 5);


-------------------------------------
-- 2 Classes de 2ème année 2020 - S1
-------------------------------------

-------------------------------------
-- 2 Classes de 2ème année 2020 - S2
-------------------------------------

-------------------------------------
-- 2 Classes de 1ème année 2019 - S1
-------------------------------------

-------------------------------------
-- 2 Classes de 1ème année 2019 - S2
-------------------------------------

-- Elèves
INSERT INTO personne VALUES (7, 'Kingsworth', '1991-10-28', false, 92);
INSERT INTO personne VALUES (8, 'Hixson', '1995-01-30', true, 64);
INSERT INTO personne VALUES (9, 'Baudrey', '1999-10-06', false, 81);
INSERT INTO personne VALUES (10, 'Muzzall', '1995-01-23', false, 1);
INSERT INTO personne VALUES (11, 'Lamanby', '1990-10-03', true, 18);
INSERT INTO personne VALUES (12, 'Edmenson', '1998-07-14', false, 93);
INSERT INTO personne VALUES (13, 'Keenor', '1994-12-07', true, 22);
INSERT INTO personne VALUES (14, 'Shucksmith', '1999-11-14', false, 25);
INSERT INTO personne VALUES (15, 'Ferrick', '1994-12-21', false, 32);
INSERT INTO personne VALUES (16, 'Verey', '1996-12-23', true, 90);
INSERT INTO personne VALUES (17, 'Marmon', '1996-02-14', false, 43);
INSERT INTO personne VALUES (18, 'Ingerman', '1993-01-08', false, 95);
INSERT INTO personne VALUES (19, 'Rhys', '1990-06-22', true, 74);
INSERT INTO personne VALUES (20, 'Osgar', '1995-11-02', false, 4);
INSERT INTO personne VALUES (21, 'Rendbaek', '1993-04-22', false, 62);
INSERT INTO personne VALUES (22, 'Brabben', '1996-12-09', false, 76);
INSERT INTO personne VALUES (23, 'Ogglebie', '1993-05-26', true, 61);
INSERT INTO personne VALUES (24, 'Caherny', '1997-01-11', true, 85);
INSERT INTO personne VALUES (25, 'Markwelley', '1992-07-03', false, 95);
INSERT INTO personne VALUES (26, 'Taberner', '1990-04-01', false, 99);
INSERT INTO personne VALUES (27, 'Woffinden', '1992-09-08', true, 99);
INSERT INTO personne VALUES (28, 'Waddams', '1991-08-23', true, 44);
INSERT INTO personne VALUES (29, 'Bayford', '1995-05-01', true, 92);
INSERT INTO personne VALUES (30, 'Antonsson', '1995-12-05', false, 73);
INSERT INTO personne VALUES (31, 'Tremblot', '1999-12-19', true, 10);
INSERT INTO personne VALUES (32, 'Turfs', '1994-02-02', true, 18);
INSERT INTO personne VALUES (33, 'Pairpoint', '1994-06-07', true, 37);
INSERT INTO personne VALUES (34, 'Basezzi', '1990-04-04', false, 82);
INSERT INTO personne VALUES (35, 'Maulin', '1999-04-25', false, 79);
INSERT INTO personne VALUES (36, 'Rudolfer', '1996-01-28', false, 35);
INSERT INTO personne VALUES (37, 'Thurlbeck', '1992-12-04', false, 48);
INSERT INTO personne VALUES (38, 'Clemett', '1995-01-30', true, 24);
INSERT INTO personne VALUES (39, 'Arntzen', '1991-01-15', false, 9);
INSERT INTO personne VALUES (40, 'Padgett', '1991-10-23', false, 27);
INSERT INTO personne VALUES (41, 'Attock', '1990-08-30', false, 57);
INSERT INTO personne VALUES (42, 'Lucock', '1995-09-14', true, 79);
INSERT INTO personne VALUES (43, 'Baradel', '1993-07-30', true, 12);
INSERT INTO personne VALUES (44, 'McInnerny', '1999-11-14', false, 42);
INSERT INTO personne VALUES (45, 'Wilden', '1996-07-04', false, 72);
INSERT INTO personne VALUES (46, 'Tejero', '1997-01-23', true, 53);
INSERT INTO personne VALUES (47, 'Goggey', '1996-03-27', false, 33);
INSERT INTO personne VALUES (48, 'Trevain', '1992-06-19', true, 76);
INSERT INTO personne VALUES (49, 'Fist', '1998-08-16', true, 56);
INSERT INTO personne VALUES (50, 'Hurles', '1997-01-13', false, 64);
INSERT INTO personne VALUES (51, 'Tewelson', '1991-02-01', false, 79);
INSERT INTO personne VALUES (52, 'Dahlen', '1993-08-06', true, 69);
INSERT INTO personne VALUES (53, 'Thomasson', '1996-02-07', false, 52);
INSERT INTO personne VALUES (54, 'Fairebrother', '1992-10-09', true, 78);
INSERT INTO personne VALUES (55, 'Yesenev', '1995-02-16', true, 31);
INSERT INTO personne VALUES (56, 'Blinckhorne', '1992-03-30', true, 76);
INSERT INTO personne VALUES (57, 'Sweetland', '1991-08-06', false, 64);
INSERT INTO personne VALUES (58, 'Buff', '1997-01-25', false, 91);
INSERT INTO personne VALUES (59, 'Starmer', '1998-10-02', true, 77);
INSERT INTO personne VALUES (60, 'Dilrew', '1993-02-17', true, 3);
INSERT INTO personne VALUES (61, 'Verner', '1993-02-26', true, 54);
INSERT INTO personne VALUES (62, 'Lupton', '1990-01-22', true, 51);
INSERT INTO personne VALUES (63, 'Manzell', '1995-05-27', true, 12);
INSERT INTO personne VALUES (64, 'Johnes', '1992-07-12', true, 60);
INSERT INTO personne VALUES (65, 'Spinelli', '1991-07-11', true, 44);
INSERT INTO personne VALUES (66, 'Luther', '1997-07-19', false, 15);
INSERT INTO personne VALUES (67, 'Benedetti', '1995-08-25', true, 79);
INSERT INTO personne VALUES (68, 'Gravener', '1997-10-28', false, 94);
INSERT INTO personne VALUES (69, 'Nancekivell', '1993-04-10', true, 26);
INSERT INTO personne VALUES (70, 'Babb', '1992-02-21', false, 24);
INSERT INTO personne VALUES (71, 'Pistol', '1990-07-26', true, 93);
INSERT INTO personne VALUES (72, 'Teather', '1992-08-26', false, 43);
INSERT INTO personne VALUES (73, 'Gouthier', '1999-08-17', false, 19);
INSERT INTO personne VALUES (74, 'Ashburner', '1999-04-27', false, 48);
INSERT INTO personne VALUES (75, 'Baudts', '1990-10-19', false, 17);
INSERT INTO personne VALUES (76, 'Moresby', '1993-04-17', true, 56);
INSERT INTO personne VALUES (77, 'Lyddiard', '1999-05-03', false, 95);
INSERT INTO personne VALUES (78, 'Macy', '1998-06-06', true, 54);
INSERT INTO personne VALUES (79, 'Ilewicz', '1997-02-06', true, 88);
INSERT INTO personne VALUES (80, 'Gilchrist', '1999-04-01', false, 84);
INSERT INTO personne VALUES (81, 'Hansill', '1991-01-01', false, 62);
INSERT INTO personne VALUES (82, 'Bettridge', '1999-06-05', true, 17);
INSERT INTO personne VALUES (83, 'Swindlehurst', '1999-03-28', false, 52);
INSERT INTO personne VALUES (84, 'Alfonsetto', '1995-02-19', true, 82);
INSERT INTO personne VALUES (85, 'Derdes', '1997-05-30', false, 99);
INSERT INTO personne VALUES (86, 'Toppas', '1994-07-17', true, 61);
INSERT INTO personne VALUES (87, 'Jemison', '1995-05-13', false, 38);
INSERT INTO personne VALUES (88, 'Itzkovitch', '1994-10-06', false, 28);
INSERT INTO personne VALUES (89, 'MacKimmie', '1999-02-27', false, 46);
INSERT INTO personne VALUES (90, 'Wilmott', '1994-05-04', false, 73);
INSERT INTO personne VALUES (91, 'Underdown', '1991-08-14', true, 83);
INSERT INTO personne VALUES (92, 'Terrazzo', '1995-12-24', true, 63);
INSERT INTO personne VALUES (93, 'Ripper', '1997-07-15', true, 51);
INSERT INTO personne VALUES (94, 'Wedon', '1997-09-07', false, 56);
INSERT INTO personne VALUES (95, 'Slograve', '1998-05-08', false, 82);
INSERT INTO personne VALUES (96, 'Pendlenton', '1995-09-23', true, 84);
INSERT INTO personne VALUES (97, 'Claypole', '1997-10-24', true, 42);
INSERT INTO personne VALUES (98, 'Ehlerding', '1996-08-26', true, 84);
INSERT INTO personne VALUES (99, 'Huortic', '1993-02-10', false, 82);
INSERT INTO personne VALUES (100, 'Mallabon', '1992-09-09', true, 63);
INSERT INTO personne VALUES (101, 'Bourdon', '1994-10-24', true, 73);
INSERT INTO personne VALUES (102, 'Drewry', '1990-06-11', false, 30);
INSERT INTO personne VALUES (103, 'Crockford', '1998-05-21', true, 56);
INSERT INTO personne VALUES (104, 'Padden', '1995-07-07', true, 35);
INSERT INTO personne VALUES (105, 'Layland', '1993-04-02', true, 71);
INSERT INTO personne VALUES (106, 'Willshire', '1994-11-14', false, 86);

INSERT INTO prénom VALUES (7, 'Nathalie');
INSERT INTO prénom VALUES (8, 'Ethel');
INSERT INTO prénom VALUES (9, 'Vannie');
INSERT INTO prénom VALUES (10, 'Sheilah');
INSERT INTO prénom VALUES (11, 'Trula');
INSERT INTO prénom VALUES (12, 'Joanne');
INSERT INTO prénom VALUES (13, 'Aeriela');
INSERT INTO prénom VALUES (14, 'Imogen');
INSERT INTO prénom VALUES (15, 'Andi');
INSERT INTO prénom VALUES (16, 'Ania');
INSERT INTO prénom VALUES (17, 'Aridatha');
INSERT INTO prénom VALUES (18, 'Celisse');
INSERT INTO prénom VALUES (19, 'Margy');
INSERT INTO prénom VALUES (20, 'Christabel');
INSERT INTO prénom VALUES (21, 'Emlynn');
INSERT INTO prénom VALUES (22, 'Leann');
INSERT INTO prénom VALUES (23, 'Cori');
INSERT INTO prénom VALUES (24, 'Goldi');
INSERT INTO prénom VALUES (25, 'Oralle');
INSERT INTO prénom VALUES (26, 'Elora');
INSERT INTO prénom VALUES (27, 'Debora');
INSERT INTO prénom VALUES (28, 'Imogen');
INSERT INTO prénom VALUES (29, 'Aimil');
INSERT INTO prénom VALUES (30, 'Evania');
INSERT INTO prénom VALUES (31, 'Carlie');
INSERT INTO prénom VALUES (32, 'Dareen');
INSERT INTO prénom VALUES (33, 'Monique');
INSERT INTO prénom VALUES (34, 'Arlie');
INSERT INTO prénom VALUES (35, 'Goldy');
INSERT INTO prénom VALUES (36, 'Mari');
INSERT INTO prénom VALUES (37, 'Emelyne');
INSERT INTO prénom VALUES (38, 'Letty');
INSERT INTO prénom VALUES (39, 'Kalinda');
INSERT INTO prénom VALUES (40, 'Davida');
INSERT INTO prénom VALUES (41, 'Sidoney');
INSERT INTO prénom VALUES (42, 'Jeniffer');
INSERT INTO prénom VALUES (43, 'Thekla');
INSERT INTO prénom VALUES (44, 'Rickie');
INSERT INTO prénom VALUES (45, 'Sheelagh');
INSERT INTO prénom VALUES (46, 'Paulie');
INSERT INTO prénom VALUES (47, 'Stephana');
INSERT INTO prénom VALUES (48, 'Bunnie');
INSERT INTO prénom VALUES (49, 'Chelsea');
INSERT INTO prénom VALUES (50, 'Helaina');
INSERT INTO prénom VALUES (51, 'Aliza');
INSERT INTO prénom VALUES (52, 'Marylin');
INSERT INTO prénom VALUES (53, 'Frayda');
INSERT INTO prénom VALUES (54, 'Allis');
INSERT INTO prénom VALUES (55, 'Tiertza');
INSERT INTO prénom VALUES (56, 'Carlene');
INSERT INTO prénom VALUES (57, 'Silvan');
INSERT INTO prénom VALUES (58, 'Sarge');
INSERT INTO prénom VALUES (59, 'Kinny');
INSERT INTO prénom VALUES (60, 'Mattias');
INSERT INTO prénom VALUES (61, 'Sigismund');
INSERT INTO prénom VALUES (62, 'Jean');
INSERT INTO prénom VALUES (63, 'Judas');
INSERT INTO prénom VALUES (64, 'Haven');
INSERT INTO prénom VALUES (65, 'Roosevelt');
INSERT INTO prénom VALUES (66, 'Cello');
INSERT INTO prénom VALUES (67, 'Keefer');
INSERT INTO prénom VALUES (68, 'Sam');
INSERT INTO prénom VALUES (69, 'Baron');
INSERT INTO prénom VALUES (70, 'Thaddeus');
INSERT INTO prénom VALUES (71, 'Basilio');
INSERT INTO prénom VALUES (72, 'Consalve');
INSERT INTO prénom VALUES (73, 'Jefferey');
INSERT INTO prénom VALUES (74, 'Adrian');
INSERT INTO prénom VALUES (75, 'Quintin');
INSERT INTO prénom VALUES (76, 'Alwyn');
INSERT INTO prénom VALUES (77, 'Morie');
INSERT INTO prénom VALUES (78, 'Pierce');
INSERT INTO prénom VALUES (79, 'Rodrick');
INSERT INTO prénom VALUES (80, 'Aron');
INSERT INTO prénom VALUES (81, 'Yancey');
INSERT INTO prénom VALUES (82, 'Eamon');
INSERT INTO prénom VALUES (83, 'Perry');
INSERT INTO prénom VALUES (84, 'Morlee');
INSERT INTO prénom VALUES (85, 'Keelby');
INSERT INTO prénom VALUES (86, 'Benton');
INSERT INTO prénom VALUES (87, 'Brig');
INSERT INTO prénom VALUES (88, 'Adelbert');
INSERT INTO prénom VALUES (89, 'Marc');
INSERT INTO prénom VALUES (90, 'Gay');
INSERT INTO prénom VALUES (91, 'Den');
INSERT INTO prénom VALUES (92, 'Riordan');
INSERT INTO prénom VALUES (93, 'Liam');
INSERT INTO prénom VALUES (94, 'Lennie');
INSERT INTO prénom VALUES (95, 'Donovan');
INSERT INTO prénom VALUES (96, 'Gay');
INSERT INTO prénom VALUES (97, 'Marvin');
INSERT INTO prénom VALUES (98, 'Rick');
INSERT INTO prénom VALUES (99, 'Winnie');
INSERT INTO prénom VALUES (100, 'Lannie');
INSERT INTO prénom VALUES (101, 'Silas');
INSERT INTO prénom VALUES (102, 'Demetre');
INSERT INTO prénom VALUES (103, 'Arty');
INSERT INTO prénom VALUES (104, 'Brock');
INSERT INTO prénom VALUES (105, 'Robinson');
INSERT INTO prénom VALUES (106, 'Bernard');

INSERT INTO etudiant VALUES (7, 'En cours');
INSERT INTO etudiant VALUES (8, 'En cours');
INSERT INTO etudiant VALUES (9, 'En cours');
INSERT INTO etudiant VALUES (10, 'En cours');
INSERT INTO etudiant VALUES (11, 'En cours');
INSERT INTO etudiant VALUES (12, 'En cours');
INSERT INTO etudiant VALUES (13, 'En cours');
INSERT INTO etudiant VALUES (14, 'En cours');
INSERT INTO etudiant VALUES (15, 'En cours');
INSERT INTO etudiant VALUES (16, 'En cours');
INSERT INTO etudiant VALUES (17, 'En cours');
INSERT INTO etudiant VALUES (18, 'En cours');
INSERT INTO etudiant VALUES (19, 'En cours');
INSERT INTO etudiant VALUES (20, 'En cours');
INSERT INTO etudiant VALUES (21, 'En cours');
INSERT INTO etudiant VALUES (22, 'En cours');
INSERT INTO etudiant VALUES (23, 'En cours');
INSERT INTO etudiant VALUES (24, 'En cours');
INSERT INTO etudiant VALUES (25, 'En cours');
INSERT INTO etudiant VALUES (26, 'En cours');
INSERT INTO etudiant VALUES (27, 'En cours');
INSERT INTO etudiant VALUES (28, 'En cours');
INSERT INTO etudiant VALUES (29, 'En cours');
INSERT INTO etudiant VALUES (30, 'En cours');
INSERT INTO etudiant VALUES (31, 'En cours');
INSERT INTO etudiant VALUES (32, 'En cours');
INSERT INTO etudiant VALUES (33, 'En cours');
INSERT INTO etudiant VALUES (34, 'En cours');
INSERT INTO etudiant VALUES (35, 'En cours');
INSERT INTO etudiant VALUES (36, 'En cours');
INSERT INTO etudiant VALUES (37, 'En cours');
INSERT INTO etudiant VALUES (38, 'En cours');
INSERT INTO etudiant VALUES (39, 'En cours');
INSERT INTO etudiant VALUES (40, 'En cours');
INSERT INTO etudiant VALUES (41, 'En cours');
INSERT INTO etudiant VALUES (42, 'En cours');
INSERT INTO etudiant VALUES (43, 'En cours');
INSERT INTO etudiant VALUES (44, 'En cours');
INSERT INTO etudiant VALUES (45, 'En cours');
INSERT INTO etudiant VALUES (46, 'En cours');
INSERT INTO etudiant VALUES (47, 'En cours');
INSERT INTO etudiant VALUES (48, 'En cours');
INSERT INTO etudiant VALUES (49, 'En cours');
INSERT INTO etudiant VALUES (50, 'En cours');
INSERT INTO etudiant VALUES (51, 'En cours');
INSERT INTO etudiant VALUES (52, 'En cours');
INSERT INTO etudiant VALUES (53, 'En cours');
INSERT INTO etudiant VALUES (54, 'En cours');
INSERT INTO etudiant VALUES (55, 'En cours');
INSERT INTO etudiant VALUES (56, 'En cours');
INSERT INTO etudiant VALUES (57, 'En cours');
INSERT INTO etudiant VALUES (58, 'En cours');
INSERT INTO etudiant VALUES (59, 'En cours');
INSERT INTO etudiant VALUES (60, 'En cours');
INSERT INTO etudiant VALUES (61, 'En cours');
INSERT INTO etudiant VALUES (62, 'En cours');
INSERT INTO etudiant VALUES (63, 'En cours');
INSERT INTO etudiant VALUES (64, 'En cours');
INSERT INTO etudiant VALUES (65, 'En cours');
INSERT INTO etudiant VALUES (66, 'En cours');
INSERT INTO etudiant VALUES (67, 'En cours');
INSERT INTO etudiant VALUES (68, 'En cours');
INSERT INTO etudiant VALUES (69, 'En cours');
INSERT INTO etudiant VALUES (70, 'En cours');
INSERT INTO etudiant VALUES (71, 'En cours');
INSERT INTO etudiant VALUES (72, 'En cours');
INSERT INTO etudiant VALUES (73, 'En cours');
INSERT INTO etudiant VALUES (74, 'En cours');
INSERT INTO etudiant VALUES (75, 'En cours');
INSERT INTO etudiant VALUES (76, 'En cours');
INSERT INTO etudiant VALUES (77, 'En cours');
INSERT INTO etudiant VALUES (78, 'En cours');
INSERT INTO etudiant VALUES (79, 'En cours');
INSERT INTO etudiant VALUES (80, 'En cours');
INSERT INTO etudiant VALUES (81, 'En cours');
INSERT INTO etudiant VALUES (82, 'En cours');
INSERT INTO etudiant VALUES (83, 'En cours');
INSERT INTO etudiant VALUES (84, 'En cours');
INSERT INTO etudiant VALUES (85, 'En cours');
INSERT INTO etudiant VALUES (86, 'En cours');
INSERT INTO etudiant VALUES (87, 'En cours');
INSERT INTO etudiant VALUES (88, 'En cours');
INSERT INTO etudiant VALUES (89, 'En cours');
INSERT INTO etudiant VALUES (90, 'En cours');
INSERT INTO etudiant VALUES (91, 'En cours');
INSERT INTO etudiant VALUES (92, 'En cours');
INSERT INTO etudiant VALUES (93, 'En cours');
INSERT INTO etudiant VALUES (94, 'En cours');
INSERT INTO etudiant VALUES (95, 'En cours');
INSERT INTO etudiant VALUES (96, 'En cours');
INSERT INTO etudiant VALUES (97, 'En cours');
INSERT INTO etudiant VALUES (98, 'En cours');
INSERT INTO etudiant VALUES (99, 'En cours');
INSERT INTO etudiant VALUES (100, 'En cours');
INSERT INTO etudiant VALUES (101, 'En cours');
INSERT INTO etudiant VALUES (102, 'En cours');
INSERT INTO etudiant VALUES (103, 'En cours');
INSERT INTO etudiant VALUES (104, 'En cours');
INSERT INTO etudiant VALUES (105, 'En cours');
INSERT INTO etudiant VALUES (106, 'En cours');

