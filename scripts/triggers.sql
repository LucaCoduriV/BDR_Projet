-- Un étudiant ne peut pas avoir un test d'un cours qu'il ne suit pas

CREATE OR REPLACE FUNCTION check_if_user_has_cours()
    RETURNS TRIGGER LANGUAGE plpgsql AS
$BODY$
BEGIN
    IF EXISTS(
        SELECT * FROM etudiant_leçon
        INNER JOIN leçon ON leçon.numéro = etudiant_leçon.noleçon AND leçon.idcours = etudiant_leçon.idleçon
        WHERE etudiant_leçon.idetudiant = NEW.idetudiant AND EXISTS(
            SELECT *
            FROM test
            WHERE test.id = NEW.idtest AND leçon.idcours = test.idcours)) THEN
        RETURN NEW;
    ELSE
        IF(TG_OP = 'UPDATE') THEN
            RETURN OLD;
        ELSE
            RETURN NULL;
        END IF;
    END IF;
END;
$BODY$;

DROP TRIGGER IF EXISTS before_insert_or_update_etudiant_test ON etudiant_test;
CREATE TRIGGER before_insert_or_update_etudiant_test
BEFORE INSERT OR UPDATE ON etudiant_test
FOR EACH ROW
EXECUTE FUNCTION check_if_user_has_cours();

-- Un élève ne peut pas être un professeur en même temps.

CREATE OR REPLACE FUNCTION check_etudiant_not_professeur()
    RETURNS TRIGGER LANGUAGE plpgsql AS
$BODY$
BEGIN
    IF NOT EXISTS(SELECT etudiant.idpersonne FROM etudiant INNER JOIN professeur ON NEW.idpersonne = professeur.idpersonne) THEN
        RETURN NEW;
    ELSE
        RAISE EXCEPTION 'Un étudiant ne peut être un professeur en même temps.';
    END IF;
END;
$BODY$;

DROP TRIGGER IF EXISTS before_insert_or_update_etudiant ON etudiant;
CREATE TRIGGER before_insert_or_update_etudiant
BEFORE INSERT OR UPDATE ON etudiant
FOR EACH ROW
EXECUTE FUNCTION check_etudiant_not_professeur();

-- Un professeur ne peut pas être un élève en même temps.

CREATE OR REPLACE FUNCTION check_professeur_not_etudiant()
    RETURNS TRIGGER LANGUAGE plpgsql AS
$BODY$
BEGIN
    IF NOT EXISTS(SELECT professeur.idpersonne FROM professeur INNER JOIN etudiant ON etudiant.idpersonne = NEW.idpersonne) THEN
        RETURN NEW;
    ELSE
        RAISE EXCEPTION 'Un professeur ne peut être un étudiant en même temps.';
    END IF;
END;
$BODY$;

DROP TRIGGER IF EXISTS before_insert_or_update_professeur ON professeur;
CREATE TRIGGER before_insert_or_update_professeur
BEFORE INSERT OR UPDATE ON professeur
FOR EACH ROW
EXECUTE FUNCTION check_professeur_not_etudiant();

-- Check si plages horaires se chevauchent.

CREATE OR REPLACE FUNCTION check_plagehoraire_chevauchent()
    RETURNS TRIGGER LANGUAGE plpgsql AS
$BODY$
BEGIN
    IF NOT EXISTS(SELECT * FROM plagehoraire WHERE (NEW.heuredébut > plagehoraire.heuredébut AND NEW.heuredébut < plagehoraire.heurefin) OR (NEW.heurefin > plagehoraire.heuredébut AND NEW.heurefin < plagehoraire.heurefin)) THEN
        RETURN NEW;
    ELSE
        RAISE EXCEPTION 'Il n''est pas possible d''avoir une plage horaire aux heures spécifiées';
    END IF;
END;
$BODY$;

DROP TRIGGER IF EXISTS before_insert_or_update_plagehoraire on plagehoraire;
CREATE TRIGGER before_insert_or_update_plagehoraire
BEFORE INSERT OR UPDATE ON plagehoraire
FOR EACH ROW
EXECUTE FUNCTION check_plagehoraire_chevauchent();

-- Une leçon ne peut pas durer plus longtemps qu’il n’y a de périodes dans la journée

CREATE OR REPLACE FUNCTION check_duree_lecon()
    RETURNS TRIGGER LANGUAGE plpgsql AS
$BODY$
BEGIN
    IF (NEW.noplagehoraire + NEW.nbrpériodes - 1) <= (SELECT MAX(plagehoraire.numéro) FROM plagehoraire) THEN
        RETURN NEW;
    ELSE
        RAISE EXCEPTION 'La durée de la leçon est trop longue.';
    END IF;
END;
$BODY$;

DROP TRIGGER IF EXISTS before_insert_or_update_leçon ON leçon;
CREATE TRIGGER before_insert_or_update_leçon
BEFORE INSERT OR UPDATE ON leçon
FOR EACH ROW
EXECUTE FUNCTION check_duree_lecon();

-- Un étudiant ne peux pas participer à plusieurs leçons qui ont lieu en même temps

CREATE OR REPLACE FUNCTION check_etudiant_lecon_overlap()
    RETURNS TRIGGER LANGUAGE plpgsql AS
$BODY$
    DECLARE plagehoraire leçon.noplagehoraire%type;
    DECLARE duree leçon.nbrpériodes%type;
    DECLARE jour leçon.joursemaine%type;

BEGIN
    SELECT noplagehoraire, nbrpériodes, joursemaine
    FROM leçon
    WHERE numéro = NEW.noleçon AND idcours = NEW.idleçon
    INTO plagehoraire, duree, jour;

    IF (EXISTS(
        SELECT leçon.nbrpériodes
        FROM leçon
        INNER JOIN etudiant_leçon ON leçon.numéro = etudiant_leçon.noleçon AND leçon.idcours = etudiant_leçon.idleçon
        WHERE etudiant_leçon.idetudiant = NEW.idetudiant AND leçon.joursemaine = jour
            AND (
                leçon.noplagehoraire BETWEEN plagehoraire AND plagehoraire + duree
                OR leçon.noplagehoraire + leçon.nbrpériodes BETWEEN plagehoraire AND plagehoraire + duree
                OR plagehoraire BETWEEN leçon.noplagehoraire AND leçon.noplagehoraire + leçon.nbrpériodes
                OR plagehoraire + duree BETWEEN leçon.noplagehoraire AND leçon.noplagehoraire + leçon.nbrpériodes
            )
        )
    ) THEN
        RAISE EXCEPTION 'L''étudiant à déjà une leçon à ce moment.';
    ELSE
        RETURN NEW;
    END IF;
END;
$BODY$;

DROP TRIGGER IF EXISTS before_insert_or_update_etudiant_leçon ON etudiant_leçon;
CREATE TRIGGER before_insert_or_update_etudiant_leçon
BEFORE INSERT OR UPDATE ON etudiant_leçon
    FOR EACH ROW
EXECUTE FUNCTION check_etudiant_lecon_overlap();

-- Un professeur ne peux pas participer à plusieurs leçons qui ont lieu en même temps

CREATE OR REPLACE FUNCTION check_professeur_lecon_overlap()
    RETURNS TRIGGER LANGUAGE plpgsql AS
$BODY$
    DECLARE plagehoraire leçon.noplagehoraire%type;
    DECLARE duree leçon.nbrpériodes%type;
    DECLARE jour leçon.joursemaine%type;

BEGIN
    SELECT noplagehoraire, nbrpériodes, joursemaine
    FROM leçon
    WHERE numéro = NEW.numéro AND idcours = NEW.idcours
    INTO plagehoraire, duree, jour;

    IF (EXISTS(
            SELECT leçon.nbrpériodes
            FROM leçon
            WHERE leçon.idprofessseur = NEW.idprofessseur AND leçon.joursemaine = jour
              AND (
                    leçon.noplagehoraire BETWEEN plagehoraire AND plagehoraire + duree
                    OR leçon.noplagehoraire + leçon.nbrpériodes BETWEEN plagehoraire AND plagehoraire + duree
                    OR plagehoraire BETWEEN leçon.noplagehoraire AND leçon.noplagehoraire + leçon.nbrpériodes
                    OR plagehoraire + duree BETWEEN leçon.noplagehoraire AND leçon.noplagehoraire + leçon.nbrpériodes
                )
        )
    ) THEN
        RAISE EXCEPTION 'Le professeur à déjà une leçon à ce moment.';
    ELSE
        RETURN NEW;
    END IF;
END;
$BODY$;

DROP TRIGGER IF EXISTS before_insert_or_update_leçon2 ON leçon;
CREATE TRIGGER before_insert_or_update_leçon2
BEFORE INSERT OR UPDATE ON leçon
    FOR EACH ROW
EXECUTE FUNCTION check_professeur_lecon_overlap();

-- Un étudiant ne peut pas suivre 2 cours de semestre différents mais d’une même année

CREATE OR REPLACE FUNCTION check_etudiant_lecon_semestre_annee()
    RETURNS TRIGGER LANGUAGE plpgsql AS
$BODY$
    DECLARE numero semestre.numéro%type;
    DECLARE annee semestre.année%type;

BEGIN
    SELECT nosemestre, annéesemestre
    FROM cours
    WHERE id = NEW.idleçon
    INTO numero, annee;

    IF (EXISTS(
            SELECT leçon.nbrpériodes
            FROM leçon
            INNER JOIN etudiant_leçon ON leçon.numéro = etudiant_leçon.noleçon AND leçon.idcours = etudiant_leçon.idleçon
            INNER JOIN cours on leçon.idcours = cours.id
            WHERE etudiant_leçon.idetudiant = NEW.idetudiant AND cours.annéesemestre = annee AND cours.nosemestre != numero
        )
    ) THEN
        RAISE EXCEPTION 'L''étudiant à déjà des cours d''un autre semestre.';
    ELSE
        RETURN NEW;
    END IF;
END;
$BODY$;

DROP TRIGGER IF EXISTS before_insert_or_update_etudiant_leçon2 ON etudiant_leçon;
CREATE TRIGGER before_insert_or_update_etudiant_leçon2
BEFORE INSERT OR UPDATE ON etudiant_leçon
    FOR EACH ROW
EXECUTE FUNCTION check_etudiant_lecon_semestre_annee();