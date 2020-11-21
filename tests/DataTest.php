<?php

use PHPUnit\Framework\TestCase;

require 'CsvFileIterator.php';

class DataTest extends TestCase
{
 /**
  * @dataProvider additionProvider
  */
 public function testAdd($a, $b, $expected)
 {
  $this->assertSame($expected, $a + $b);
 }

 public function additionProvider()
 {
  return new CsvFileIterator('data.csv');
 }
}
