--postgres offshoa_db;
--DROP TABLE IF EXISTS admins;
CREATE TABLE
if not exists categories
(
 id SERIAL NOT NULL,
 category VARCHAR
(255) NOT NULL,
 created_at TIMESTAMP,
 updated_at TIMESTAMP,
 PRIMARY KEY
(id)
);

CREATE TABLE
if not exists posts
(
 id SERIAL NOT NULL,
 title VARCHAR
(255),
 detail VARCHAR
(255),
 image VARCHAR
(255),
 created_at TIMESTAMP,
 updated_at TIMESTAMP,
 PRIMARY KEY
(id)
);

CREATE TABLE
if not exists admins
(
 id SERIAL NOT NULL,
 name VARCHAR
(255) NOT NULL,
 password VARCHAR
(255),
 created_at TIMESTAMP,
 updated_at TIMESTAMP,
 PRIMARY KEY
(id)
);

CREATE TABLE
if not exists tags
(
 id SERIAL NOT NULL,
 tag VARCHAR
(255) NOT NULL, 
 created_at TIMESTAMP,
 updated_at TIMESTAMP,
 PRIMARY KEY
(id)
);

CREATE TABLE
if not exists post_tag
(
 id SERIAL NOT NULL,
 post_id INT not null references  posts
(id) ON
DELETE CASCADE,
 tag_id INT
not null references  tags
(id) ON
DELETE CASCADE,
 created_at TIMESTAMP,
 updated_at TIMESTAMP,
 PRIMARY KEY
(id)
);

CREATE TABLE
if not exists users
(
 id SERIAL NOT NULL,
 name VARCHAR
(255) NOT NULL, 
 password VARCHAR
(255),
 created_at TIMESTAMP,
 updated_at TIMESTAMP,
 PRIMARY KEY
(id)
);

CREATE TABLE
if not exists follows
(
 id SERIAL NOT NULL primary key,
 follow_id INT not null references  users
(id) ON
DELETE CASCADE,
 follower_id INT
not null references users
(id) ON
DELETE CASCADE,
 created_at TIMESTAMP,
 updated_at TIMESTAMP,
 UNIQUE
(follow_id, follower_id)
);

CREATE TABLE
if not exists likes
(
 id SERIAL NOT NULL,
 post_id INT,
 user_id INT,
 foreign key
(post_id) references posts
(id) ON
DELETE CASCADE ON
Update CASCADE,
 foreign key (user_id) references users(id)
ON
DELETE CASCADE ON
Update CASCADE,
 created_at TIMESTAMP,
 updated_at TIMESTAMP,
 PRIMARY KEY
(id)
);

CREATE TABLE
if not exists post_category
(
 id SERIAL NOT NULL,
 post_id INT,
 category_id INT,
 foreign key
(post_id) references posts
(id) ON
DELETE CASCADE ON
Update CASCADE,
 foreign key (category_id) references categories(id)
ON
DELETE CASCADE ON
Update CASCADE,
 created_at TIMESTAMP,
 updated_at TIMESTAMP,
 PRIMARY KEY
(id)
);

ALTER TABLE posts ADD
IF NOT EXISTS like_count INT;

ALTER TABLE posts ADD
IF NOT EXISTS user_id INT default 1;

ALTER TABLE posts ADD
IF NOT EXISTS delete_flag INT default 0;