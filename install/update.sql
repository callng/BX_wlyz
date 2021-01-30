CREATE TABLE {ABC}black(
id int auto_increment,
feature varchar(255) NOT NULL default '',
type tinyint NOT NULL,
menber_id int NOT NULL,
software_id int NOT NULL,
comment varchar(255) NOT NULL default '',
time varchar(20) NOT NULL default '',
PRIMARY KEY(id),
UNIQUE (feature,type,software_id)
) ENGINE = MyISAM CHARSET=utf8;</explode>