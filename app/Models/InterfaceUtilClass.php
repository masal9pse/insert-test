<?php

namespace App\Models;

interface InterfaceUtilClass
{
 // インターフェースではプロパティの使用ができない

 function dbConnect();

 function getAllData();

 function getById(int $id);

 function sanitize($inputs);

 public function setToken();

 function auth_check($redirectPath);

 function empty_check($key, $name);

 public function queryPost($stmt);
}
