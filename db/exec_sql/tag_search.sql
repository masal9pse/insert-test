SELECT *
FROM posts
 LEFT JOIN post_tag
 ON posts.id = post_tag.post_id
 LEFT JOIN tags
 ON tags.id = post_tag.tag_id
WHERE tags.tag = '面白い';

-- カテゴリー＋タグの絞込み検索
SELECT *
FROM posts
 LEFT JOIN post_tag
 ON posts.id = post_tag.post_id
 LEFT JOIN tags
 ON tags.id = post_tag.tag_id
 LEFT JOIN post_category
 ON posts.id = post_category.post_id
 LEFT JOIN categories
 ON categories.id = post_category.category_id
WHERE tags.tag = '面白い' and categories.category='アニメ';


-- キーワード+カテゴリー＋タグのand検索
-- Naruto
SELECT *
FROM posts
 LEFT JOIN post_tag
 ON posts.id = post_tag.post_id
 LEFT JOIN tags
 ON tags.id = post_tag.tag_id
 LEFT JOIN post_category
 ON posts.id = post_category.post_id
 LEFT JOIN categories
 ON categories.id = post_category.category_id
WHERE tags.tag = '面白い' and categories.category='アニメ' AND posts.title like '%N%' or posts.detail like '%N%';