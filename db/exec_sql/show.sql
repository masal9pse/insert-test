select users.*
from users
 inner join posts
 on users.id = posts.user_id
where posts.user_id = 1
group by users.id;

SELECT *
FROM users u, posts p
WHERE u.id=p.user_id AND u.id=1 and p.id = 4;