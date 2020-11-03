<!-- カテゴリーをselectboxにしたい -->
<?php
require('dbconnect.php');
$db = dbConnect();
$category_sql = 'SELECT * from categories';
$stmt = $db->query($category_sql);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

$tag_sql = 'SELECT * from tags';
$stmt = $db->query($tag_sql);
$tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($categories);
?>

<!DOCTYPE html>
<html>

<head>
  <metacharset="utf-8">
    <title>検索機能</title>
</head>

<body>
  <h1>検索フォーム</h1>
  <a href="./list.php">全件表示リンク</a>
  <a href="./insert_form.php">投稿リンク</a>
  <!--<form action="search.php" method="get">-->
  <form action="searchCategoryTag.php" method="get">
    <select name="category">
      <option value="">未選択</option>
      <?php foreach ($categories as $category) : ?>
        <option value="<?php echo $category['category']; ?>"><?php echo $category['category']; ?></option>
      <?php endforeach; ?>
    </select>
    <input type="text" name="search" placeholder="検索したい値">
    <br>
    <?php foreach ($tags as $tag) : ?>
      <input type="checkbox" name="tags[]" value="<?php echo $tag['tag']; ?>">
      <label for="<?php echo $tag['tag']; ?>"><?php echo $tag['tag']; ?></label>
    <?php endforeach; ?>
    </select>
    <input type="submit" value="送信" />
  </form>
</body>

</html>