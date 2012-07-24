<?php

use Minwork\Route;

//Route::set("contact.html", "controller/action");
//Route::set("contact\-?(\d+)?\.html", 'admin/users/create/$1', true);
Route::set("example", "welcome/index"); //example route

//tell the script to look for the admin folder
Route::registerControllerPath("admin");

//set the default controller path
Route::setDefault("welcome/index");