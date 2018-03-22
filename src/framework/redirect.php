<?php
namespace Framework;

class Redirect
{ // Redirect
  public static function route($url, $with = [])
  { // route
    if(count($with))
	{
		  foreach($with as $key => $value)
		  {
			    Session::flush($key, $value);
		  }
	}
	return header("Location: {$url}");
  } // route
} // Redirect