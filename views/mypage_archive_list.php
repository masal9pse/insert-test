<?php
session_start();
ini_set('display_errors', "On");
require('../Models/Function/PostClass.php');

$post = new PostClass;
$lists = $post->postLogicalDeleteList();

if (isset($_POST['submit'])) {
 $post->postLogicalUpdate($_POST['update_id']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Document</title>
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
</head>

<body>
 <?php foreach ($lists as $list) : ?>
  <div>
   <td><?php echo $list['id']; ?></td>
   <td><?php echo $list['title']; ?></td>
   <form action="" method="post" style="display:inline;">
    <input type="hidden" name="update_id" value="<?php echo $list['id']; ?>">
    <button type="submit" name="submit">復元する</button>
   </form>
  </div>
 <?php endforeach ?>
</body>

</html>