<?php
use Routing\Route;

Route::create("search", array("controller" => "Post", "action" => "search"));

Route::create("{controller}/{action}/{id}", array());

Route::create("{controller}/{action}", array("controller" => "Post", "action" => "all"));