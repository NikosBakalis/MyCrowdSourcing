DROP PROCEDURE IF EXISTS filter_json;

DELIMITER $$
 
CREATE PROCEDURE filter_json(IN  activity_stream VARCHAR(255))
BEGIN
    DECLARE activities VARCHAR(255);
    DECLARE tmp VARCHAR(255);
    SELECT activity_stream INTO activities;
    DROP TABLE IF EXISTS activity_stream;
    CREATE TABLE activity_table(
        activity_type VARCHAR(20)
    );
    WHILE (activities > '') DO
        SELECT SUBSTRING_INDEX(activities, '.', 1) INTO tmp;
        SELECT tmp;
        INSERT INTO activity_table VALUES (tmp);
        SELECT REPLACE(activities, tmp, ' ') INTO activities;
        SELECT TRIM(activities) INTO activities;
        SELECT SUBSTR(activities, 2) INTO activities;
        SELECT TRIM(activities) INTO activities;
        SELECT activities;
    END WHILE;
    SELECT * FROM activity_table;
END$$

DELIMITER ;

CALL filter_json("WALKING.STILL.DRIVING.UNKNOWN");