CREATE TABLE activity_details(
    auto_inc INT AUTO_INCREMENT NOT NULL,
    userID VARCHAR(200) NOT NULL,
    timestamp_l DATETIME NOT NULL,
    timestamp_a DATETIME NOT NULL,
    type VARCHAR(12) NOT NULL,
    confidence TINYINT NOT NULL,
    PRIMARY KEY(auto_inc),
    FOREIGN KEY(userID, timestamp_l, timestamp_a) REFERENCES activity(userID, timestamp_l, timestamp_a)
    ON DELETE CASCADE ON UPDATE CASCADE
);