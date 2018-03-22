<?php
namespace Framework;

class Session
{ // Session
  public static function set($key, $value)
  { // set
    $_SESSION[$key]['type'] = "session";
    $_SESSION[$key]['value'] = $value;
  } // set
  
  public static function get($key)
  { // get
    if(isset($_SESSION[$key]))
	{ // return session
	  $return = $_SESSION[$key]['value'];
	  
	  if($_SESSION[$key]['type'] == 'flush')
	  { // destroy session
    unset($_SESSION[$key]);
	  } // destroy session 
	  
	  return $return;
	} // return session
	else
	{
		  return false;
	}
  } // get
  
  public static function flush($key, $value)
  { // flush
    $_SESSION[$key]['type'] = "flush";
    $_SESSION[$key]['value'] = $value;
  } // flush
  
  public static function destroy($key)
  { // destroy
    if(isset($_SESSION[$key]))
	{ // destroy session
  unset($_SESSION[$key]);
	} // destroy session
  } // destroy
} // Session