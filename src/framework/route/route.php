<?php
namespace Framework;

use Jenssegers\Blade\Blade;

class Route
{ // Route
  private $routes;
  
  public function __construct(array $routes)
  { // construct
    try
	{
	  $this->setRoutes($routes);
	  $this->run();
	} catch(\Exception $e)
	{
		  echo $e->getMessage();
	}
  } // construct
  
  private function setRoutes($routes)
  { // setRoutes
    foreach($routes as $route)
	{
		  $explode = explode('@', $route[1]);
		  $r = [$route[0], $explode[0], $explode[1]];
		  $new_routes[] = $r;
	}
	
	$this->routes = $new_routes;
  } // setRoutes
  
  private function getRoutes()
  { // getRoutes
    return $this->routes;
  } // getRoutes
  
  private function getURL()
  { // getURL
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  } // getURL
  
  private function getRequest()
  { // getRequest
    $obj = new \stdClass;
	
	foreach($_GET as $key => $value)
	{
		  $obj->get = new \stdClass;
		  $obj->get->$key = $value;
	}
	
	return $obj;
  } // getRequest
  
  private function run()
  { // run
    $url = $this->getURL();
	$urlArray = explode('/', $url);
	
	foreach($this->getRoutes() as $route)
	{
	  $routeArray = explode('/', $route[0]);
	  $params = [];
	  
	  for($i=0; $i<count($routeArray);$i++)
	  {
		    if(strpos($routeArray[$i], '{') !== false && count($urlArray) == count($routeArray))
			{
				  $routeArray[$i] = $urlArray[$i];
				  $params[] = $urlArray[$i];
			}
			
			$route[0] = implode($routeArray, '/');
	  }
	  
	  if($url == $route[0])
	  {
		    $routeFound = 1;
			$controller = $route[1];
			$action = $route[2];
			break;
	  }
	}
	
	if(!isset($routeFound) or !$routeFound)
	{
		  $view = __DIR__ . '/../../../../../../app/views';
		  $cache = __DIR__ . '/../../../../../../cache';
		  $blade = new Blade($view, $cache);
		  echo $blade->make('errors.404');
	}
	else
	{
		  $controller = Container::newController($controller);
		  
		  if(count($params))
		  {
			    $params[] = $this->getRequest();
				call_user_func_array([$controller, $action], $params);
		  }
		  else
		  {
			    $controller->$action($this->getRequest());
		  }
	}
  } // run
} // Route