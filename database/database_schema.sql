CREATE DATABASE IF NOT EXISTS mi_red_social;
USE mi_red_social;

CREATE TABLE users(
id       int(255) PRIMARY KEY AUTO_INCREMENT NOT NULL ,
role     varchar(20),
email    varchar(255),
name     varchar(255),
surname  varchar(255),
password varchar(255),
nick     varchar(50),
bio      varchar(255),
image    varchar(255),
CONSTRAINT users_uniques_fields UNIQUE (email, nick)
)ENGINE = InnoDb;


CREATE TABLE publications(
id       int(255) PRIMARY KEY AUTO_INCREMENT NOT NULL,
user_id  int(255),
text     mediumtext,
document varchar(100),
image    varchar(255),
status   varchar(30),
created_at datetime,
CONSTRAINT fk_publications_users FOREIGN KEY(user_id) references users(id)
)ENGINE = InnoDb;


CREATE TABLE following(
id       int(255) PRIMARY KEY AUTO_INCREMENT,
user     int(255),
followed int(255),
CONSTRAINT fk_following_users FOREIGN KEY(user) references users(id),
CONSTRAINT fk_followed FOREIGN KEY(followed) references users(id)
)ENGINE = InnoDb;


CREATE TABLE private_messages(
id       int(255) PRIMARY KEY AUTO_INCREMENT NOT NULL,
message  longtext,
emitter  int(255),
receiver int(255),
file     varchar(255),
image    varchar(255),
readed   varchar(3),
created_at datetime,
CONSTRAINT fk_emmiter_privates FOREIGN KEY(emitter) references users(id),
CONSTRAINT fk_receiver_privates FOREIGN KEY(receiver) references users(id)
)ENGINE = InnoDb;


CREATE TABLE likes(
id          int(255) PRIMARY KEY AUTO_INCREMENT NOT NULL,
user        int(255),
publication int(255),
CONSTRAINT fk_likes_users FOREIGN KEY(user) references users(id),
CONSTRAINT fk_likes_publication FOREIGN KEY(publication) references publications(id)
)ENGINE = InnoDb;


CREATE TABLE notifications(
id        int(255) PRIMARY KEY AUTO_INCREMENT NOT NULL,
user_id   int(255),
type      varchar(255),
type_id   int(255),
readed    varchar(3),
created_at datetime,
extra     varchar(100),
CONSTRAINT fk_notifications_users FOREIGN KEY(user_id) references users(id)
)ENGINE = InnoDb;