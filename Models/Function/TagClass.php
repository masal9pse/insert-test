<?php
require_once dirname(__FILE__) . '/../UtilClass.php';

class TagClass extends UtilClass
{
 protected $table_name = 'tags';
 protected $sort = 'asc';

 public static function searchFormStatic()
 {
  return '検索フォーム';
 }

 public static function callSearchFormStatic()
 {
  return self::searchFormStatic() . 'だよ！';
 }
}
