<?php
namespace Framework;

class Container
{ // Container
  public static function newController(string $controller)
  { // newController
    $controller = 'App\\Controllers\\'.$controller;
	return new $controller;
  } // newController
} // Container