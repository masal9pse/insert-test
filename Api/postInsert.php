<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
require('../Classes/Function/PostClass.php');

class PostInsert extends PostClass
{
 protected $table_name = 'posts';
 public $id;
 public $user_id;
 public $category_name;
 public $title;
 public $detail;
 public $image;
 public $created_at;

 // Create Post
 public function create()
 {
  // postgresはset使えない説？
  // Create query  
  $sql = 'INSERT INTO posts(title,detail,user_id) VALUES (:title,:detail,:user_id)';

  // Prepare statement
  $db = $this->dbConnect();
  $stmt = $db->prepare($sql);
  // Clean data
  $this->title = htmlspecialchars(strip_tags($this->title));
  $this->detail = htmlspecialchars(strip_tags($this->detail));
  //$this->image = htmlspecialchars(strip_tags($this->image));
  $this->user_id = htmlspecialchars(strip_tags($this->user_id));

  // Bind data
  $stmt->bindValue(':title', $this->title);
  $stmt->bindValue(':detail', $this->detail);
  //$stmt->bindValue(':image', $this->image);
  $stmt->bindValue(':user_id', $this->user_id);
  //$stmt->execute();
  // Execute query
  if ($stmt->execute()) {
   return true;
  }

  // Print error if something goes wrong
  printf("Error: %s.\n", $stmt->error);

  return false;
 }
}
$postInsert = new PostInsert;

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));
//$data = json_decode(file_get_contents("./Api/postInsert.php"));

$postInsert->title = $data->title;
$postInsert->detail = $data->detail;
//$postInsert->image = $data->image;
$postInsert->user_id = $data->user_id;

// Create post
if ($postInsert->create()) {
 echo json_encode(
  array('message' => 'Post Created')
 );
} else {
 echo json_encode(
  array('message' => 'Post Not Created')
 );
}
