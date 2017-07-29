<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spider;

class ProductController extends Controller
{
    public function index(){
        $spider = new Spider();
        return $spider->shop_item_search();
    }
}
