<?php
namespace Framework;

use Jenssegers\Blade\Blade;

class Controller
{ // Controller
  protected $view;
  private $viewPath;
  
  protected function render($viewPath, $params = array())
  { // render
    $this->viewPath = $viewPath;
	$view = __DIR__ . '/../../app/views';
	$cache = __DIR__ . '/../../cache';
	
	try
	{
	  $blade = new Blade($view, $cache);
	  echo $blade->make($this->viewPath, $params);
	} catch(\Exception $e)
	{
		  echo $e->getMessage();
	}
  } // render
} // Controller