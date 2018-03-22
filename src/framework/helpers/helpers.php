<?php
if(!function_exists('dd'))
{
  function dd($dump)
  {
	    echo '<pre>';
		var_dump($dump);
	    echo '</pre>';
		die;
  }
}
	
if(!function_exists('asset'))
{
  function asset($path = '/')
  {
	    $http = sprintf("%s://%s", isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http', $_SERVER['SERVER_NAME']);
		return $http . $path;
  }
}