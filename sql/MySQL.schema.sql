-- MySQL schema

CREATE TABLE tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    token VARCHAR(255) UNIQUE NOT NULL
);

CREATE TABLE cities (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255),
    country VARCHAR(255),
    population INT,
    lat DOUBLE,
    lon DOUBLE,
    PRIMARY KEY (id)
);
