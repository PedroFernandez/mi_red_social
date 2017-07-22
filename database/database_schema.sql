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
CONSTRAINT users_uniques_field_email UNIQUE (email),
CONSTRAINT users_uniques_field_nick UNIQUE (nick)
)ENGINE = InnoDb;

ALTER TABLE users ADD INDEX index_users_id (id);
ALTER TABLE users ADD INDEX index_users_nick (nick);

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

ALTER TABLE publications ADD INDEX index_publications_id (id);
ALTER TABLE publications ADD INDEX index_publications_user_id (user_id);

CREATE TABLE following(
id       int(255) PRIMARY KEY AUTO_INCREMENT,
user     int(255),
followed int(255),
CONSTRAINT fk_following_users FOREIGN KEY(user) references users(id),
CONSTRAINT fk_followed FOREIGN KEY(followed) references users(id)
)ENGINE = InnoDb;

ALTER TABLE following ADD INDEX index_following_id (id);
ALTER TABLE following ADD INDEX index_following_user_id (user);

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

ALTER TABLE private_messages ADD INDEX index_private_messages_id (id);
ALTER TABLE private_messages ADD INDEX index_private_messages_emitter (emitter);

CREATE TABLE likes(
id          int(255) PRIMARY KEY AUTO_INCREMENT NOT NULL,
user        int(255),
publication int(255),
CONSTRAINT fk_likes_users FOREIGN KEY(user) references users(id),
CONSTRAINT fk_likes_publication FOREIGN KEY(publication) references publications(id)
)ENGINE = InnoDb;

ALTER TABLE likes ADD INDEX index_likes_id (id);
ALTER TABLE likes ADD INDEX index_likes_user (user);

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

ALTER TABLE notifications ADD INDEX index_notifications_id (id);
ALTER TABLE notifications ADD INDEX index_notifications_user_id (user_id);