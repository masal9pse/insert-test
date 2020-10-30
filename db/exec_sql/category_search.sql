--なぜか狙った結果が取得できる
SELECT posts.*
FROM posts
 JOIN post_tag AS pt ON posts.id = pt.post_id
 JOIN tags ON pt.tag_id = tags.id
WHERE tags.tag IN ('感動できる','面白い','アニメ化')
GROUP BY posts.id
HAVING COUNT(posts.id) = 3;

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
categories.category='音楽';
--posts.id=3;
--categories.id=1;

SELECT *
from posts
where title='ナルト' or detail='アニメと映画';

-- Narutoを取得、曖昧検索
SELECT *
FROM posts
where  posts.title like '%N%' or posts.detail like '%N%';

-- ナルトが取得できた。
SELECT *
FROM posts
 LEFT JOIN post_category
 ON posts.id = post_category.post_id
 LEFT JOIN categories
 ON categories.id = post_category.category_id
WHERE categories.category = 'アニメ' and posts.title like '%N%';

-- なぜかand検索で値が取れない
SELECT *
FROM posts LEFT JOIN post_tag ON posts.id = post_tag.post_id
 LEFT JOIN tags ON tags.id = post_tag.tag_id
where tags.tag='面白い' AND tags.tag='感動できる';

-- ？なぜかとれない
SELECT *
FROM posts LEFT JOIN post_tag ON posts.id = post_tag.post_id
 LEFT JOIN tags ON tags.id = post_tag.tag_id
where post_tag.tag_id=1 and post_tag.tag_id=2;

-- or検索で重複した値を削除する
SELECT DISTINCT posts.*
FROM posts LEFT JOIN post_tag ON posts.id = post_tag.post_id
 LEFT JOIN tags ON tags.id = post_tag.tag_id
where post_tag.tag_id=1 or post_tag.tag_id=2;

-- タグ検索に使用するsql => これ使う => 絞り込みができない
SELECT DISTINCT posts.*
FROM posts LEFT JOIN post_tag ON posts.id = post_tag.post_id
 LEFT JOIN tags ON tags.id = post_tag.tag_id
where tags.tag='面白い' OR tags.tag='感動できる';

-- 絞り込みできない
SELECT distinct posts.*, tags.*
FROM posts LEFT JOIN post_tag ON posts.id = post_tag.post_id
 LEFT JOIN tags ON tags.id = post_tag.tag_id
where tags.tag　IN ('面白い','感動できる','アニメ化');