CREATE TABLE user(
    id VARCHAR(200) NOT NULL,
    firstname TINYTEXT NOT NULL,
    lastname TINYTEXT NOT NULL,
    username TINYTEXT NOT NULL,
    email TINYTEXT NOT NULL,
    pwd LONGTEXT NOT NULL,
    type VARCHAR(20) DEFAULT 'user', CONSTRAINT values_table check (type in ('user', 'admin')),
    latest_upload DATETIME,
    eco_score FLOAT(5,2),
    PRIMARY KEY(id),
    UNIQUE(email)
);
