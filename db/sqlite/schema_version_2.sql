CREATE TABLE arrays (
	path VARCHAR(255),
	value TEXT
);

CREATE UNIQUE INDEX array_path ON arrays(path);


INSERT INTO schema_migrations(version) VALUES(2);