DROP PROCEDURE IF EXISTS filter_json;

DELIMITER $$

CREATE PROCEDURE filter_json(IN time_begin DATETIME, IN time_end DATETIME, IN  activity_stream VARCHAR(255))
BEGIN
    DECLARE activities VARCHAR(255);
    DECLARE tmp VARCHAR(255);
    SELECT activity_stream INTO activities;
    DROP TABLE IF EXISTS activity_table;
    CREATE TABLE activity_table(
        activity_type VARCHAR(20)
    );
    WHILE (activities > '') DO
        SELECT SUBSTRING_INDEX(activities, '.', 1) INTO tmp;
        /*SELECT tmp;*/
        INSERT INTO activity_table VALUES (tmp);
        SELECT REPLACE(activities, tmp, ' ') INTO activities;
        SELECT TRIM(activities) INTO activities;
        SELECT SUBSTR(activities, 2) INTO activities;
        SELECT TRIM(activities) INTO activities;
        /*SELECT activities;*/
    END WHILE;
    SELECT * FROM activity_table;
    select * from location
    inner join activity
    on location.userID = activity.userID
    and location.timestamp_l = activity.timestamp_l
    inner join activity_details
    on activity.userID = activity_details.userID
    and activity.timestamp_l = activity_details.timestamp_l
    and activity.timestamp_a = activity_details.timestamp_a
    where activity_details.type in (select * from activity_table)
    AND (activity_details.timestamp_l BETWEEN time_begin AND time_end);

END$$

DELIMITER ;

CALL filter_json('2018-05-03 11:53:49', '2018-05-03 14:36:23', 'WALKING.STILL.DRIVING.UNKNOWN');
