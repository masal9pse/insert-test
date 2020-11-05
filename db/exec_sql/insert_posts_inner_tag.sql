-- likesテーブルからレコードを削除する
DELETE FROM likes WHERE post_id = 3 AND user_id = 14

--数をカウントする
select *, count(post_id)
from likes
where post_id=10
group by likes.id;

INSERT INTO posts
 (title,detail,image,created_at,updated_at)
VALUES
 ('秒速５cm', '面白い', 'a', now(), now());


-- postsテーブルのtitle,detailカラムにtagsTableのid,tagをインサートする
INSERT INTO posts
 (title,detail)
SELECT tags.id, tags.tag
from tags;

INSERT INTO tags
VALUES
 (1, '海外');

alter table bbs_thread add foreign key (creator_id) references accounts_user(id);