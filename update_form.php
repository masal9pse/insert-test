<?php
include('dbconnect.php');
//var_dump($_GET);
$sql = 'SELECT * from posts where id=:id';
$stmt = $db->prepare($sql);
$stmt->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
$stmt->execute();
$update_post = $stmt->fetch(PDO::FETCH_ASSOC);
var_dump($update_post);
?>

<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>更新画面</title>
</head>

<body>
 <form action="update.php" method="post">
  <p><?php echo $update_post['title']; ?></p>
  <p><?php echo $update_post['detail']; ?></p>
  <img src="<?php echo 'images/' . $update_post['image'] ?>" alt="">
  <input type="submit" value="編集する">
 </form>
</body>

</html>