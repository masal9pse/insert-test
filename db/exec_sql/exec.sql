-- カテゴリー検索の未完成例
SELECT posts.* , categories.*
from categories
 inner join posts
 on categories.id = posts.category_id
where posts.category_id=2;

-- 3つのテーブルの結合　カテゴリー検索機能
SELECT
 *
FROM
 posts
 LEFT JOIN
 post_category
 ON
posts.id = post_category.post_id
 LEFT JOIN
 categories
 ON
categories.id = post_category.category_id
WHERE
--posts.id=3;
categories.id=1;