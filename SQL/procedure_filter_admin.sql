DELIMITER $$
 
CREATE PROCEDURE filter_json(IN  activity_stream VARCHAR(255))
BEGIN
    DECLARE activities VARCHAR(255);
    DECLARE tmp VARCHAR(255);
    SELECT activity_stream INTO activities;
    WHILE (activities > '') DO
        SELECT SUBSTRING_INDEX(activities, '.', 1) INTO tmp;
        SELECT tmp;
        SELECT REPLACE(activities, tmp, ' ') INTO activities;
        SELECT TRIM(activities) INTO activities;
        SELECT SUBSTR(activities, 2) INTO activities;
        SELECT TRIM(activities) INTO activities;
        SELECT activities;
    END WHILE;
END$$

DELIMITER ;

CALL filter_json("WALKING.STILL.DRIVING.UNKNOWN");