<?php

namespace App\Controllers;

use App\Controllers\UtilController;
use App\Models\TagModel;

final class TagController extends UtilController
{
 public function __construct($table_name, $sort)
 {
  $this->table_name = $table_name;
  $this->sort = $sort;
 }


 //public static function callSearchFormStatic()
 //{
 // return self::searchFormStatic() . 'だよ！';
 //}
}
