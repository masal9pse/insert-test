-- アーカイブしていないものだけ一覧表示
SELECT *
from posts
where delete_flag=0
order by id asc;

--　認証ユーザーのアーカイブ一覧
SELECT *
from posts
where delete_flag= 1
 and user_id = :auth_id
order by id asc
;


-- 論理削除実行
UPDATE posts SET delete_flag=1 where id=1

UPDATE posts SET delete_flag=0 where id=1