-- Un étudiant ne peut pas avoir un test d'un cours qu'il ne suit pas

CREATE OR REPLACE FUNCTION check_if_user_has_cours()
    RETURNS TRIGGER LANGUAGE plpgsql as
$BODY$
begin
    if EXISTS(select * FROM etudiant_leçon el INNER JOIN leçon l on l.numéro = el.noleçon and l.idcours = el.idleçon
WHERE el.idetudiant = NEW.idetudiant AND EXISTS(select * FROM test t WHERE t.id = NEW.idtest AND l.idcours = t.idcours)) then
        RETURN NEW;
    else
        IF(TG_OP = 'UPDATE') THEN
            RETURN OLD;
        ELSE
            RETURN NULL;
        END IF;
    end if;
end;
$BODY$;

CREATE OR REPLACE TRIGGER before_insert_or_update_etudiant_test
BEFORE INSERT OR UPDATE ON etudiant_test
FOR EACH ROW
EXECUTE FUNCTION check_if_user_has_cours();