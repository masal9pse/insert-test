<?php
$sql = 'SELECT * from posts 
inner join users 
on posts.user_id = users.id
where users.id=1';
