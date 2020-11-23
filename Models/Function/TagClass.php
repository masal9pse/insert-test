<?php
require_once dirname(__FILE__) . '/../UtilClass.php';

final class TagClass extends UtilClass
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
