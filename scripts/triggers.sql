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