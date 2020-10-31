--Naruto,天気の子
SELECT count(*), posts.*
FROM posts
 LEFT JOIN post_category
 ON posts.id = post_category.post_id
 LEFT JOIN categories
 ON categories.id = post_category.category_id
 JOIN post_tag
 ON posts.id = post_tag.post_id
 JOIN tags
 ON post_tag.tag_id = tags.id
WHERE  categories.category = 'アニメ'
 AND tags.tag IN ('感動できる','面白い')
 AND posts.title like '%%'
GROUP BY posts.id
HAVING COUNT(posts.id) = 2;

SELECT count(*), posts.*
FROM posts
 LEFT JOIN post_category
 ON posts.id = post_category.post_id
 LEFT JOIN categories
 ON categories.id = post_category.category_id
 JOIN post_tag
 ON posts.id = post_tag.post_id
 JOIN tags
 ON post_tag.tag_id = tags.id
WHERE  categories.category = 'アニメ'
 AND tags.tag IN ('感動できる','面白い','アニメ化')
 AND posts.title like '%天%'
GROUP BY posts.id
HAVING COUNT(posts.id) = 3;

SELECT count(*), posts.*
FROM posts
 LEFT JOIN post_category
 ON posts.id = post_category.post_id
 LEFT JOIN categories
 ON categories.id = post_category.category_id
 JOIN post_tag
 ON posts.id = post_tag.post_id
 JOIN tags
 ON post_tag.tag_id = tags.id
WHERE  categories.category = 'アニメ'
 AND tags.tag IN ('感動できる','面白い')
 AND posts.title like '%%'
GROUP BY posts.id
HAVING COUNT(posts.id) = 3;