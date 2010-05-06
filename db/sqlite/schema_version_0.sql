CREATE TABLE schema (
	version INT
);
CREATE INDEX ON schema(version);































--- Lastly, insert the schema version
INSERT INTO schema(version) VALUES(0);

