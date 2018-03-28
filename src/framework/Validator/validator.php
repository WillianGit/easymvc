<?php
namespace Framework\Validator;

class Validator
{ // Validator
  private $error = [];
  
  public static function make(array $data, array $rules)
  { // make
    $instance = new static;
	
	foreach($rules as $ruleKey => $ruleValue)
	{
		  foreach($data as $dataKey => $dataValue)
		  {
			    if($ruleKey == $dataKey)
				{
					  $itemsValue = [];
					  if(strpos($ruleKey, '|'))
					  {
						    $itemsValue = explode('|', $ruleValue);
							foreach($itemsValue as $itemValue)
							{
								  $subitems = [];
								  if(strpos($itemValue, ':'))
								  {
									    $subitems = explode(':', $itemValue);
										$instance->checkSubItems($subitems, $ruleKey, $dataValue);
								  }
								  else
								  {
									    $instance->checkItems($itemValue, $ruleKey, $dataValue);
								  }
							}
					  }
					  elseif(strpos($ruleValue, ':'))
					  {
						    $items = explode(':', $ruleValue);
							$instance->checkSubItems($items, $ruleKey, $dataValue);
					  }
					  else
					  {
						    $instance->checkItems($ruleValue, $ruleKey, $dataValue);
					  }
				}
		  }
	}
	
	return $instance;
  } // make
  
  private function checkSubItems(array $subitems, $field, $value)
  { // checkSubItems
    switch($subitems[0]
	{
		  case 'min' :
		    if(strlen($value) < (int) $subitems[1])
			{
			$this->error["$field"} = "O campo {$field} deve ter no mínimo {$subitems[1]} caracteres.";
			}
		  break;
		  
		  case 'max' :
		    if(strlen($value) > (int) $subitems[1])
			{
			$this->error["$field"} = "O campo {$field} deve ter no máximo {$subitems[1]} caracteres.";
			}
		  break;
	}
	
	return $this;
  } // checkSubItems
  
  private function checkItems($item, $field, $value)
  { // checkItems
    switch($item)
	{
		  case 'required' :
		    if$value == '' || (trim(empty($value)))
			{
				  $this->error["$field"] = "O preenchimento do campo {$field} é obrigatório.";
			}
		  break;
		  
		  case 'email' :
		    if(!filter_var($value, FILTER_VALIDATE_EMAIL))
			{
				  $this->error["$field"] = "O campo {$field} deve conter um e-mail válido.";
			}
		  break;
	}
	
	return $this;
  } // checkItems
} // Validator