CREATE TABLE activity_details(
    userID VARCHAR(200) NOT NULL,
    timestamp_l DATETIME NOT NULL,
    timestamp_a DATETIME NOT NULL,
    type VARCHAR(20) NOT NULL,
    confidence TINYINT NOT NULL,
    PRIMARY KEY(userID, timestamp_l, timestamp_a, type),
    FOREIGN KEY(userID, timestamp_l, timestamp_a) REFERENCES activity(userID, timestamp_l, timestamp_a)
    ON DELETE CASCADE ON UPDATE CASCADE
);
