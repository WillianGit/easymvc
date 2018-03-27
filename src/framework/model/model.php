<?php
namespace Framework\Model;

use PDO;

abstract class Model
{ // Model
  private $pdo;
  protected $table;
  private $query;
  private $where;
  private $orWhere;
  
  public function __construct()
  { // construct
    $this->pdo = Database::getDatabase();
	$this->query = "SELECT * FROM {$this->table}";
  } // construct
  
  public static function select(array $data)
  { // select
    $instance = new static;
	$data = implode(', ', $data);
	$instance->query = "SELECT {$data} FROM {$instance->table}";
	return $instance;
  } // select
  
  public static function where(array $data)
  { // where
    $instance = new static;
	$instance->where = $instance->prepareDataWhere($data);
	$instance->query .= " WHERE {$instance->where[0]}";
	
	return $instance;
  } // where
  
  private function prepareDataWhere(array $data)
  { // prepareDataWhere
    $strBinds = "";
	$binds = [];
	$values = [];
	
	foreach($data as $key => $value)
	{
		  $strBinds = "{$strBinds} AND {$key}=:{$key}";
		  $binds[] = ":{$key}";
		  $values[] = $value;
	}
	
	$strBinds = substr($strBinds, 5);
	return [
	  $strBinds,
	  $binds,
	  $values
	];
  } // prepareDataWhere
  
  public function get()
  { // get
    $stmt = $this->pdo->prepare($this->query);
	
	if(is_array($this->where))
	{
	  for($i=0; $i<count($this->where[1]); $i++)
	  {
	    $stmt->bindValue($this->where[1][$i], $this->where[2][$i]);
	  }
	}
	$stmt->execute();
	$result = $stmt->fetch();
	$stmt->closeCursor();
	return $result;
  } // get
  
  public static function all()
  { // all
    $instance = new static;
	$query = "SELECT * FROM {$instance->table}";
	$stmt = $instance->pdo->prepare($query);
	$stmt->execute();
	$result = $stmt->fetchAll();
	$stmt->closeCursor();
	return $result;
  } // all
  
  public static function find(int $id)
  { // find
    $instance = new static;
	$query = "Select * FROM {$instance->table} WHERE id = :id";
	$stmt = $instance->pdo->prepare($query);
	$stmt->bindValue(':id', $id);
	$stmt->execute();
	$result = $stmt->fetch();
	$stmt->closeCursor();
	return $result;
  } // find
  
  public static function create(array $data)
  { // create
    $instance = new static;
	$data = $instance->prepareDataInsert($data);
	
	$query = "INSERT INTO {$instance->table} ({$data[0]}) VALUES ({$data[1]})";
	$stmt = $instance->pdo->prepare($query);
	for($i=0; $i<count($data[2]); $i++)
	{
		  $stmt->bindValue("{$data[2][$i]}", $data[3][$i]);
	}
	$result = $stmt->execute();
	$stmt->closeCursor();
	return $result;
  } // create
  
  public static function update(array $data, $id)
  { // update
    $instance = new static;
	$data = $instance->prepareDataUpdate($data);
	$query = "UPDATE {$instance->table} SET $data[0] WHERE id=:id";
	$stmt = $instance->pdo->prepare($query);
	$stmt->bindValue(':id', $id);
	for($i=0; $i<count($data[1]); $i++)
	{
	  $stmt->bindValue($data[1][$i], $data[2][$i]);
	}
	$result = $stmt->execute();
	$stmt->closeCursor();
	return $result;
  } // update
  
  public static function delete(int $id)
  { // delete
    $instance = new static;
	$query = "DELETE FROM {$instance->table} WHERE id=:id";
	$stmt = $instance->pdo->prepare($query);
	$stmt->bindValue(':id', $id);
	$result = $stmt->execute();
	$stmt->closeCursor();
	return $result;
  } // delete
  
  private function prepareDataInsert(array $data)
  { // prepareDataInsert
    $strKeys = "";
	$strBinds = "";
	$binds = [];
	$values = [];
	
	foreach($data as $key => $value)
	{
		  $strKeys = "{$strKeys}, {$key}";
		  $strBinds = "{$strBinds}, :{$value}";
		  $binds[] = ":{$key}";
		  $values[] = $value;
	}
	
	$strKeys = substr($strKeys, 1);
	$strBinds = substr($strBinds, 1);
	
	return [
	  $strKeys,
	  $strBinds,
	  $binds,
	  $values
	];
  } // prepareDataInsert
  
  private function prepareDataUpdate(array $data)
  { // prepareDataUpdate
    $strBinds = "";
	$binds = [];
	$values = [];
	
	foreach($data as $key => $value)
	{
		  $strBinds = "{$strBinds}, {$key}=:{$key}";
		  $binds[] = ":{$key}";
		  $values[] = $value;
	}
	
	$strBinds = substr($strBinds, 1);
	return [
	  $strBinds,
	  $binds,
	  $values
	];
  } // prepareDataUpdate
  
  public function toString()
  { // toString
    return $this->query;
  } // toString
} // Model