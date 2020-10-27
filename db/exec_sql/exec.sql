SELECT posts.* , categories.*
from categories
 inner join posts
 on categories.id = posts.category_id
where posts.category_id=2;