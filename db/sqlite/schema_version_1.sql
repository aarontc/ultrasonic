CREATE TABLE schema_migrations (
version INTEGER
);

CREATE UNIQUE INDEX schema_version ON schema_migrations(version);


CREATE TABLE strings (
path VARCHAR(255),
value TEXT
);

CREATE UNIQUE INDEX string_path ON strings(path);


-- Finally, update the schema version
INSERT INTO schema_migrations(version) VALUES(1);

