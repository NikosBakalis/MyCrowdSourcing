CREATE TABLE location(
	userID VARCHAR(200) NOT NULL,
    timestamp_l DATETIME NOT NULL,
    latitude DECIMAL(10, 8) NOT NULL,
    longtitude DECIMAL(11, 8) NOT NULL,
    accuracy MEDIUMINT,
    heading SMALLINT,
    vertical_accuracy TINYINT,
    velocity TINYINT,
    altitude MEDIUMINT,
    PRIMARY KEY (userID, timestamp_l),
    FOREIGN KEY (userID) REFERENCES user(id)
    ON DELETE CASCADE ON UPDATE CASCADE
);
