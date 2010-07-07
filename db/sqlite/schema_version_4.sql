BEGIN TRANSACTION;

CREATE TABLE artist (
	id INTEGER PRIMARY KEY,
	name VARCHAR(1024)
);


CREATE TABLE album (
	id INTEGER PRIMARY KEY,
	name VARCHAR(1024)
);


CREATE TABLE song (
	id INTEGER PRIMARY KEY,
	collection INTEGER REFERENCES collection(id),
	path VARCHAR(10000),
	artist INTEGER REFERENCES artist(id),
	album INTEGER REFERENCES album(id),
	tracknum INTEGER DEFAULT NULL,
	title VARCHAR(1024),
	lyric TEXT
);


CREATE UNIQUE INDEX artist_name ON artist(name);
CREATE UNIQUE INDEX album_name ON album(name);
CREATE INDEX song_lyric ON song(lyric);


INSERT INTO schema_migrations(version) VALUES(4);

COMMIT TRANSACTION;