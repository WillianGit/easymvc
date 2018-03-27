<?php
namespace Framework\Request;

class Request
{ // Request
  public function get($name)
  { // get
    return $_GET[$name];
  } // get
  
  public function post($name)
  { // post
    return $_POST[$name];
  } // post
} // Request