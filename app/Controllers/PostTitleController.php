<?php

namespace App\Controllers;

use App\Models\PostTitleModel;

class PostTitleController
{
 public function run()
 {
  $model = new PostTitleModel;
  echo $model->getTitle();
 }
}
