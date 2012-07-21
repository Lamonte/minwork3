<?php

use Minwork\Route;

//Route::set("contact.html", "controller/action");
Route::set("contact\-?(\d+)?\.html", 'admin/users/create/$1', true);

//tell the script to look for the admin folder
Route::register_controller_path("admin");

//set the default controller path
Route::set_default("welcome/home");