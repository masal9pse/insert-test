<?php

namespace App\Models;

use App\Models\UtilModel;

final class TagModel extends UtilModel
{
 public function __construct($table_name, $sort)
 {
  $this->table_name = $table_name;
  $this->sort = $sort;
 }


 public static function callSearchFormStatic()
 {
  return self::searchFormStatic() . 'だよ！';
 }
}
