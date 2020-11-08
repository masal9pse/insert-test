SELECT *
FROM likes
WHERE post_id = 10 AND user_id = 14

-- やりたいこと、膨大な記事(posts)から必要なデータを抽出したい。
--SELECT count(*), posts.*
--SELECT  distinct posts.*
SELECT distinct posts.title, *
FROM posts
 --   ここからより自分が必要なデータを取得したいため条件を絞る
 LEFT JOIN post_category
 ON posts.id = post_category.post_id
 LEFT JOIN categories
 ON categories.id = post_category.category_id
 JOIN post_tag
 ON posts.id = post_tag.post_id
 JOIN tags
 ON post_tag.tag_id = tags.id
--   ここからさらにwhereで条件を絞る
--  カテゴリーが映画のものだけ取得したい
where categories.category = '映画'
 -- タグ名が映画化のみ取得したい
 and tags.tag = '映画化'