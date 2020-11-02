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