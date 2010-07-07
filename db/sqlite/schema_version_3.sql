BEGIN TRANSACTION;

CREATE TABLE collection (
	id INTEGER PRIMARY KEY,
	path VARCHAR(1024)
);

CREATE UNIQUE INDEX collection_path ON collection(path);


INSERT INTO schema_migrations(version) VALUES(3);

COMMIT TRANSACTION;