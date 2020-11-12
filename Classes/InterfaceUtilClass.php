<?php
interface InterfaceUtilClass
{
 // インターフェースではプロパティの使用ができない

 function dbConnect();

 function getAllData();

 function getById(int $id);

 function sanitize($inputs);

 public function saveCsrf();

 function auth_check($redirectPath);

 function empty_check($key, $name);

 public function queryPost($stmt);
}
