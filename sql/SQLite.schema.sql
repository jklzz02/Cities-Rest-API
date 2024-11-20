-- SQLite3 schema

CREATE TABLE sqlite_sequence(name,seq);
CREATE TABLE tokens (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    token TEXT UNIQUE NOT NULL
);
CREATE TABLE IF NOT EXISTS "cities"
(
    id         integer collate BINARY null on conflict ignore
        constraint cities_pk
            primary key autoincrement,
    name       text,
    country    text,
    population integer,
    lat        double,
    lon        double
);
