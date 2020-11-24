<?php

namespace App\Controllers;

use App\Controllers\UtilController;
use App\Models\CategoryModel;

class CategoryController extends UtilController
{
 public $table_name = 'categories';
 public $sort = 'asc';
}
