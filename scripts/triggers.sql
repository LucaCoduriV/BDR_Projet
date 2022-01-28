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

CREATE OR REPLACE TRIGGER before_insert_or_update_etudiant_test
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

CREATE OR REPLACE TRIGGER before_insert_or_update_etudiant
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

CREATE OR REPLACE TRIGGER before_insert_or_update_professeur
BEFORE INSERT OR UPDATE ON professeur
FOR EACH ROW
EXECUTE FUNCTION check_professeur_not_etudiant();