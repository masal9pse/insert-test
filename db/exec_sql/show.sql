select users.*
from users
 inner join posts
 on users.id = posts.user_id
where posts.user_id = 1
group by users.id;