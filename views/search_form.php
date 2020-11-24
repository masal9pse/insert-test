<?php
ini_set('display_errors', "On");
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\TagController;
use App\Controllers\CategoryController;

$TagInstance = new TagController('tags', 'asc');
$categoryInstance = new CategoryController();
$tags = $TagInstance->getAllData();
$categories = $categoryInstance->getAllData();
$get = $TagInstance->sanitize($_GET);
?>

<!DOCTYPE html>
<html>

<head>
 <metacharset="utf-8">
  <title>検索機能</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</head>

<body>
 <?php $searchForm = TagController::callSearchFormStatic(); ?>
 <h3><?php print($searchForm); ?></h3>
 <a href="./index.php">全件表示リンク</a>
 <a href="./insert_form.php">投稿リンク</a>
 <form action="../Execute/search.php" method="get">
  <select name="category">
   <option value="">未選択</option>
   <?php foreach ($categories as $category) : ?>
    <option value="<?php echo $category['category']; ?>"><?php echo $category['category']; ?></option>
   <?php endforeach; ?>
  </select>
  <input type="text" name="search" placeholder="検索したい値" value="<?php $TagInstance->empty_check($get, 'search') ?>">
  <br>
  <input type="hidden" name="tags" value="">
  <?php foreach ($tags as $tag) : ?>
   <input type="checkbox" name="tags[]" value="<?php echo $tag['tag']; ?>">
   <label for="<?php echo $tag['tag']; ?>"><?php echo $tag['tag']; ?></label>
  <?php endforeach; ?>
  </select>
  <input type="submit" value="送信" />
 </form>
</body>

</html>
<script>

</script>