CREATE TABLE activity(
		userID VARCHAR(200) NOT NULL,
    timestamp_l DATETIME NOT NULL,
    timestamp_a DATETIME NOT NULL,
    PRIMARY KEY(userID, timestamp_l, timestamp_a),
    FOREIGN KEY(userID, timestamp_l) REFERENCES location(userID, timestamp_l)
		ON DELETE CASCADE ON UPDATE CASCADE
);
