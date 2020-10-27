<!-- カテゴリーをselectboxにしたい -->
<?php
require('dbconnect.php');
if (isset($_POST["fruits"])) {
 // セレクトボックスで選択された値を受け取る
 $fruit = $_POST["fruits"];

 // 受け取った値を画面に出力
 echo $fruit;
}

$sql = 'SELECT * from categories';
$stmt = $db->query($sql);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($categories);
?>

<!DOCTYPE html>
<html>

<head>
 <metacharset="utf-8">
  <title>検索機能</title>
</head>

<body>
 <h1>検索機能</h1>
 <form action="search.php" method="get">
  <select name="cagegory">
   <?php foreach ($categories as $category) : ?>
    <option value="<?php echo $category['category']; ?>"><?php echo $category['category']; ?></option>
   <?php endforeach; ?>
  </select>
  <input type="submit" name="submit" value="送信" />
 </form>
</body>

</html>