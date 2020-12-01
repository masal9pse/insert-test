<?php

use PHPUnit\Framework\TestCase;
use App\Controllers\UtilController;
use SebastianBergmann\CodeCoverage\Util;

class UtilTest extends TestCase
{
 public function testReturnArgumentStub()
 {
  // SomeClass クラスのスタブを作成します
  $stub = $this->createMock(UtilController::class);

  // スタブの設定を行います
  $stub->method('dbconnect')
   ->will($this->returnArgument(0));

  // $stub->dbconnect('foo') は 'foo' を返します
  $this->assertSame('foo', $stub->dbconnect('foo'));

  // $stub->dbconnect('bar') は 'bar' を返します
  $this->assertSame('bar', $stub->dbconnect('bar'));
 }
}
