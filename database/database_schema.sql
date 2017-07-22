CREATE DATABASE IF NOT EXISTS mi_red_social;
USE mi_red_social;

CREATE TABLE users(
id       int(255) PRIMARY KEY AUTO_INCREMENT,
role     varchar(20),
email    varchar(255),
name     varchar(255),
surname  varchar(255),
password varchar(255),
nick     varchar(50),
bio      varchar(255),
image    varchar(255)
);


CREATE TABLE publications(
id       int(255) PRIMARY KEY AUTO_INCREMENT,
user_id  int(255),
text     mediumtext,
document varchar(100),
imagen   varchar(255),
status   varchar(30),
created_at datetime
);


CREATE TABLE following(
id       int(255) PRIMARY KEY AUTO_INCREMENT,
user     int(255),
followed int(255)
);


CREATE TABLE private_messages(
id       int(255) PRIMARY KEY AUTO_INCREMENT,
message  longtext,
emitter  int(255),
receiver int(255),
file     varchar(255),
image    varchar(255),
readed   varchar(3),
created_at datetime
);


CREATE TABLE likes(
id          int(255) PRIMARY KEY AUTO_INCREMENT,
user        int(255),
publication int(255)
);


CREATE TABLE notifications(
id        int(255) PRIMARY KEY AUTO_INCREMENT,
user_id   int(255),
type      varchar(255),
type_id   int(255),
readed    varchar(3),
created_at datetime,
extra     varchar(100)
);