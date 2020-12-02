<?php

use App\Controllers\PostController;
use PHPUnit\Framework\TestCase;
use App\Controllers\UtilController;

class UtilTest extends TestCase
{
 // webコンテナに入らないとエラーになる。
 public function testDbConnect()
 {
  $mock = $this->createMock(UtilController::class);

  $db = new PDO(
   'pgsql:host=db;dbname=offshoa_db;',
   'test_user',
   'secret',
  );

  $mock->method('dbconnect')
   ->willReturn($db);

  $result = $mock->dbconnect();
  //var_dump($result);
  $this->assertIsObject($result);
  $this->assertEquals($db, $result);
 }

 // arrayが帰ってくることだけわかればいい
 public function testGetAllData()
 {
  $stub = $this->createMock(PostController::class);

  $stub->method('getAllData')
   ->willReturn([0 => ['鬼滅']]);

  $this->assertSame([0 => ['鬼滅']], $stub->getAllData());
 }

 // コンテナ内に必ず入ること
 public function testDbConnectNotUsingMock()
 {
  $util = new UtilController;
  $result = $util->dbConnect();
  $db = new PDO(
   'pgsql:host=db;dbname=offshoa_db;',
   'test_user',
   'secret',
  );
  $this->assertEquals($db, $result);
 }

 public function testGetById()
 {
  $util = new PostController;
  $result = $util->getById(1);
  $result = $result['title'];
  var_dump($result);
  $this->assertEquals('鬼滅の刃', $result);
 }
}
