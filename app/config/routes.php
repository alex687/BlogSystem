<?php
use Routing\Route;

Route::create("admin/posts/{action}/{id}", array("controller" => "PostAdmin"));

Route::create("admin/posts/{action}", array("controller" => "PostAdmin", "action" => "all"));

Route::create("{controller}/{action}/{id}", array());

Route::create("{controller}/{action}", array("controller" => "Post", "action" => "all"));