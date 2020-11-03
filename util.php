<?php
function getById($db, $id)
{
 $sql = 'SELECT * from posts where id=:id';
 $stmt = $db->prepare($sql);
 $stmt->bindValue(':id', $id, PDO::PARAM_INT);
 $stmt->execute();
 $update_post = $stmt->fetch(PDO::FETCH_ASSOC);
 return $update_post;
}
