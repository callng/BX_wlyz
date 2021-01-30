DROP TABLE IF EXISTS {ABC}menber;</explode>
CREATE TABLE {ABC}menber(
id int auto_increment,
username varchar(20) NOT NULL,
password varchar(32) NOT NULL,
power tinyint NOT NULL,
regtime varchar(20) NOT NULL default '',
regip varchar(20) NOT NULL default '',
logtime varchar(20) NOT NULL default '',
logip varchar(20) NOT NULL default '',
salt varchar(6) NOT NULL,
comment varchar(255) NOT NULL default '',
congeal tinyint NOT NULL default '1',
boss_id int NOT NULL,
money decimal(12,2) NOT NULL default '0.00',
consumed decimal(12,2) NOT NULL default '0.00',
rate tinyint NOT NULL default '0',
recharge_agent tinyint NOT NULL default '0',
default_rate tinyint NOT NULL default '0',
manager_price decimal(12,2) NOT NULL default '0.00',
default_money decimal(12,2) NOT NULL default '0.00',
software_id text NOT NULL,
PRIMARY KEY(id),
UNIQUE (username)
) ENGINE = MyISAM CHARSET=utf8;</explode>

INSERT INTO {ABC}menber (`username`, `password`, `power`,`salt`,`boss_id`,`software_id`) VALUES
 ('admin','a66abb5684c45962d887564f08346e8d','1','123456','1','');</explode>

DROP TABLE IF EXISTS {ABC}software;</explode>
CREATE TABLE {ABC}software(
id int auto_increment,
menber_id int NOT NULL,
name varchar(50) NOT NULL,
s_key varchar(255) NOT NULL,
heart_time int NOT NULL,
version varchar(50) NOT NULL default '1.0',
notice varchar(255) NOT NULL default '',
static_data varchar(255) NOT NULL default '',
give_time int NOT NULL default '0',
give_point int NOT NULL default '0',
login_type tinyint NOT NULL default '1',
update_data varchar(50) NOT NULL default '',
update_type tinyint NOT NULL default '1',
trial_interval int NOT NULL default '0',
trial_data int NOT NULL default '0',
software_state tinyint NOT NULL default '1',
binding_type tinyint NOT NULL default '1',
bindingdel_type tinyint NOT NULL default '1',
bindingdel_time int NOT NULL default '0',
bindingdel_point int NOT NULL default '0',
restrict_regtime int NOT NULL default '24',
restrict_regnum int NOT NULL default '3',
remote text NOT NULL,
encrypt varchar(50) NOT NULL default '',
defined_encrypt text NOT NULL,
PRIMARY KEY(id)
) ENGINE = MyISAM CHARSET=utf8;</explode>

DROP TABLE IF EXISTS {ABC}card_type;</explode>
CREATE TABLE {ABC}card_type(
id int auto_increment,
software_id int NOT NULL,
menber_id int NOT NULL,
name varchar(50) NOT NULL,
state tinyint NOT NULL default '1',
head varchar(255) NOT NULL default '',
time int NOT NULL,
time_type tinyint NOT NULL,
point varchar(50) NOT NULL,
money decimal(12,2) NOT NULL,
comment varchar(255) NOT NULL default '',
PRIMARY KEY(id)
) ENGINE = MyISAM CHARSET=utf8;</explode>

DROP TABLE IF EXISTS {ABC}card;</explode>
CREATE TABLE {ABC}card(
id int auto_increment,
software_id int NOT NULL,
cardnum varchar(300) NOT NULL,
name varchar(50) NOT NULL,
time int NOT NULL,
time_type tinyint NOT NULL,
point varchar(50) NOT NULL,
create_time varchar(20) NOT NULL default '',
menber_id int NOT NULL,
comment varchar(255) NOT NULL default '',
state tinyint NOT NULL default '1',
used tinyint NOT NULL default '1',
used_id int NOT NULL default '0',
PRIMARY KEY(id),
UNIQUE (cardnum)
) ENGINE = MyISAM CHARSET=utf8;</explode>

DROP TABLE IF EXISTS {ABC}config;</explode>
CREATE TABLE {ABC}config(
k varchar(255) NOT NULL default '',
v text NOT NULL,
PRIMARY KEY(k)
) ENGINE = MyISAM CHARSET=utf8;</explode>
INSERT INTO {ABC}config VALUES ('sitename','冰心网络验证');</explode>
INSERT INTO {ABC}config VALUES ('table_num','30');</explode>
INSERT INTO {ABC}config VALUES ('agent_bulletin','
<div class="alert alert-success" role="alert">
  <strong>Well done!</strong> You successfully read this important alert message.
</div>
<div class="jumbotron">
  <h1 class="display-3">Hello, world!</h1>
  <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
  <hr class="my-4">
  <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
  <p class="lead">
    <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
  </p>
</div>
');</explode>
INSERT INTO {ABC}config VALUES ('template_admin','default');</explode>
INSERT INTO {ABC}config VALUES ('template_agent','default');</explode>

DROP TABLE IF EXISTS {ABC}user;</explode>
CREATE TABLE {ABC}user(
id int auto_increment,
username varchar(20) NOT NULL,
password varchar(32) NOT NULL,
super_password varchar(32) NOT NULL,
machine_code varchar(255) NOT NULL default '',
token varchar(255) NOT NULL default '',
regtime varchar(20) NOT NULL default '',
regip varchar(20) NOT NULL default '',
logtime varchar(20) NOT NULL default '',
logip varchar(20) NOT NULL default '',
endtime varchar(20) NOT NULL default '0',
point varchar(50) NOT NULL default '0',
trial varchar(20) NOT NULL default '0',
heart_beat varchar(20) NOT NULL default '0',
congeal tinyint NOT NULL default '1',
state tinyint NOT NULL default '1',
user_data varchar(255) NOT NULL default '',
comment varchar(255) NOT NULL default '',
software_id int NOT NULL,
menber_id int NOT NULL,
salt varchar(6) NOT NULL,
PRIMARY KEY(id),
UNIQUE (username,software_id)
) ENGINE = MyISAM CHARSET=utf8;</explode>

DROP TABLE IF EXISTS {ABC}menber_log;</explode>
CREATE TABLE {ABC}menber_log(
id int auto_increment,
direction tinyint NOT NULL,
menber_id int NOT NULL,
type tinyint NOT NULL,
details varchar(500) NOT NULL default '',
ip varchar(20) NOT NULL default '',
time varchar(20) NOT NULL default '',
PRIMARY KEY(id)
) ENGINE = MyISAM CHARSET=utf8;</explode>

DROP TABLE IF EXISTS {ABC}user_log;</explode>
CREATE TABLE {ABC}user_log(
id int auto_increment,
user_id int NOT NULL,
software_id int NOT NULL,
type tinyint NOT NULL,
details varchar(500) NOT NULL default '',
ip varchar(20) NOT NULL default '',
time varchar(20) NOT NULL default '',
PRIMARY KEY(id)
) ENGINE = MyISAM CHARSET=utf8;</explode>

DROP TABLE IF EXISTS {ABC}recharge_log;</explode>
CREATE TABLE {ABC}recharge_log(
id int auto_increment,
user_id int NOT NULL,
software_id int NOT NULL,
menber_id int NOT NULL,
time int NOT NULL,
time_type tinyint NOT NULL,
point varchar(50) NOT NULL,
recharge_time varchar(20) NOT NULL default '',
endtime varchar(20) NOT NULL default '',
cardnum varchar(300) NOT NULL,
PRIMARY KEY(id)
) ENGINE = MyISAM CHARSET=utf8;</explode>

DROP TABLE IF EXISTS {ABC}agent_authority;</explode>
CREATE TABLE {ABC}agent_authority(
id int auto_increment,
menber_id int NOT NULL,
binding_state tinyint NOT NULL default '1',
offline_state tinyint NOT NULL default '1',
deluser_state tinyint NOT NULL default '1',
changepw_state tinyint NOT NULL default '1',
congeal_state tinyint NOT NULL default '1',
endtime_state tinyint NOT NULL default '1',
point_state tinyint NOT NULL default '1',
delcard_state tinyint NOT NULL default '1',
PRIMARY KEY(id)
) ENGINE = MyISAM CHARSET=utf8;</explode>

DROP TABLE IF EXISTS {ABC}agent_card;</explode>
CREATE TABLE {ABC}agent_card(
id int auto_increment,
cardnum varchar(300) NOT NULL,
name varchar(50) NOT NULL,
money decimal(12,2) NOT NULL,
create_time varchar(20) NOT NULL default '',
comment varchar(255) NOT NULL default '',
state tinyint NOT NULL default '1',
used tinyint NOT NULL default '1',
used_id int NOT NULL default '0',
PRIMARY KEY(id),
UNIQUE (cardnum)
) ENGINE = MyISAM CHARSET=utf8;</explode>

DROP TABLE IF EXISTS {ABC}template;</explode>
CREATE TABLE {ABC}template(
id int auto_increment,
name varchar(50) NOT NULL default '',
directory varchar(255) NOT NULL default '',
author varchar(50) NOT NULL default '',
author_url varchar(255) NOT NULL default '',
version varchar(255) NOT NULL default '',
description varchar(255) NOT NULL default '',
PRIMARY KEY(id),
UNIQUE (directory)
) ENGINE = MyISAM CHARSET=utf8;</explode>
INSERT INTO {ABC}template (`name`, `directory`, `author`,`author_url`,`version`,`description`) VALUES 
('默认模版','default','BingXin','http://wlyz.bingxs.com/','1.0','简洁优雅');</explode>

DROP TABLE IF EXISTS {ABC}plugin;</explode>
CREATE TABLE {ABC}plugin(
id int auto_increment,
name varchar(50) NOT NULL default '',
directory varchar(255) NOT NULL default '',
state tinyint NOT NULL default '1',
author varchar(50) NOT NULL default '',
author_url varchar(255) NOT NULL default '',
version varchar(255) NOT NULL default '',
description varchar(255) NOT NULL default '',
PRIMARY KEY(id),
UNIQUE (directory)
) ENGINE = MyISAM CHARSET=utf8;</explode>

DROP TABLE IF EXISTS {ABC}single_card;</explode>
CREATE TABLE {ABC}single_card(
id int auto_increment,
software_id int NOT NULL,
cardnum varchar(300) NOT NULL,
name varchar(50) NOT NULL,
time int NOT NULL,
time_type tinyint NOT NULL,
point varchar(50) NOT NULL,
create_time varchar(20) NOT NULL default '',
endtime varchar(20) NOT NULL default '0',
menber_id int NOT NULL,
comment varchar(255) NOT NULL default '',
congeal tinyint NOT NULL default '1',
state tinyint NOT NULL default '1',
machine_code varchar(255) NOT NULL default '',
token varchar(255) NOT NULL default '',
heart_beat varchar(20) NOT NULL default '0',
logtime varchar(20) NOT NULL default '',
logip varchar(20) NOT NULL default '',
card_data varchar(255) NOT NULL default '',
PRIMARY KEY(id),
UNIQUE (cardnum)
) ENGINE = MyISAM CHARSET=utf8;</explode>

DROP TABLE IF EXISTS {ABC}black;</explode>
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