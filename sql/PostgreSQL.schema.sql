-- PostgreSQL schema

CREATE TABLE tokens (
    id SERIAL PRIMARY KEY,
    token TEXT UNIQUE NOT NULL
);

CREATE TABLE cities (
    id SERIAL PRIMARY KEY,
    name TEXT,
    country TEXT,
    population INT,
    lat DOUBLE PRECISION,
    lon DOUBLE PRECISION
);
