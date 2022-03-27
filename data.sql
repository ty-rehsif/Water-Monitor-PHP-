INSERT INTO plants(id,p_name)
VALUES(1, 'Plant 1');

INSERT INTO plants(id,p_name)
VALUES(2, 'Plant 2');

INSERT INTO plants(id,p_name)
VALUES(3, 'Plant 3');

insert INTO plants(id,p_name)
VALUES(4, 'Plant 4');

insert INTO plants(id,p_name)
VALUES(5, 'Plant 5');

CREATE OR REPLACE FUNCTION update_watered_column() 
RETURNS TRIGGER AS $$
BEGIN
    NEW.last_watered = now();
    RETURN NEW; 
END;
$$ language 'plpgsql';

CREATE TRIGGER update_plants_changetimestamp BEFORE UPDATE
ON plants FOR EACH ROW EXECUTE PROCEDURE 
update_watered_column();
