-- 認証ユーザーのいいね一覧を表示するsql

select *
from posts
 inner join likes
 on posts.id = likes.post_id
where likes.user_id = 14;


SELECT *
from posts inner join likes on posts.id = likes.post_id
where likes.user_id = 14