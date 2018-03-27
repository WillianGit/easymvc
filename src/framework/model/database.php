<?php
namespace Framework\Model;

use PDO;
use PDOException;

class Database
{
  public static function getDatabase()
  {
	    $config = require __DIR__ . '/../../../../../../config/database.php';
		
		if($config['driver'] == 'sqlite')
		{
			  $sqlite = 'sqlite:' . __DIR__ . '/../../../../../../database/' . $config['sqlite']['database'];
			  
			  try
			  {
				    $pdo = new PDO($sqlite);
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
					return $pdo;
			  } catch(PDOException $e)
			  {
				    echo $e->getMessage();
			  }
		}
		elseif($config['driver'] == 'mysql')
		{
			  $host = $config['mysql']['host'];
			  $database = $config['mysql']['database'];
			  $user = $config['mysql']['user'];
			  $password = $config['mysql']['password'];
			  $charset = $config['mysql']['charset'];
			  $collation = $config['mysql']['collation'];
			  
			  try
			  {
				    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=$charset", $user, $password);
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES '$charset' COLLATE '$collation'");
					$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
					return $pdo;
			  } catch(PDOException $e)
			  {
				    echo $e->getMessage();
			  }
		}
  }
}