<?php
namespace Framework;

class Validator
{ // Validator
  public static function make(array $data, array $rules)
  { // make
    $error = [];
	
    foreach($rules as $ruleKey => $ruleValue)
	{ // foreach data
		  foreach($data as $dataKey => $dataValue)
		  { // check datakey and ruleKey
			    if($dataKey == $ruleKey)
				{ // check rule
					  $itemsValue = [];
					  
					  if(strpos($ruleValue, '|'))
					  { // explode rules
						    $itemsValue = explode('|', $ruleVAlue);
							
							foreach($itemsValue as $itemValue)
							{ // check itemValue
								  switch($itemValue)
								  {
									    case 'required' :
										  if(trim($dataValue) == '' || empty(trim($dataValue)))
										  {
											    $error["$ruleKey"] = "O campo {$ruleKey} é obrigatório.";
										  }
										break;
										
										case 'email' :
										  if(!filter_var($dataValue, FILTER_VALID_EMAIL))
										  {
											    $error["$ruleKey"] = "O campo {$ruleKey} deve conter um e-mail válido.";
										  }
										break;
								  }
								  
								  $subItems = [];
								  
								  if(strpos($itemValue, ':'))
								  { // explode subItems
									    $subItems = explode(':', $itemValue);
										
										switch($subItems[0])
										{
											  case 'min' :
											    if(strlen($dataValue) < $subItems[1])
												{
												$error["$ruleKey"] = "O campo {$dataKey} deve ter no mínimo {$subItems[1]} caracteres.";
												}
											  break;
											  
											  case 'max' :
											    if(strlen($dataValue) > $subItems[1])
												{
												$error["$ruleKey"] = "O campo {$dataKey} deve ter no máximo {$subItems[1]} caracteres.";
												}
											  break;
										}
								  } // explode subItems
							} // check itemValue
					  } // explode rules
				} // check rule
				elseif(strpos($ruleValue, ':'))
				{ // Senão
				  $items = explode(':', $ruleValue);
				  
				  switch($items[0]
				  {
					    case 'min' :
						  if(strlen($dataValue) < $items[1])
						  {
							    $error["$dataKey"] = ") campo {$dataKey} deve ter no mínimo {$items[1] caracteres.";
						  }
						break;
						
						case 'max' :
						  if(strlen($dataValue) > $items[1])
						  {
							    $error["$dataKey"] = ") campo {$dataKey} deve ter no máximo {$items[1] caracteres.";
						  }
						break;
				  }
				} // Senão
				else
				{
					  switch($ruleValue)
					  {
						    case 'required' :
							  if(trim($dataValue) == '' || empty(trim($dataValue)))
							  {
								   $error["$ruleKey"] = "O campo {$ruleKey} é obrigatório.";
							  }
							break;
							
							case 'email' :
							  if(!filter_var($dataValue, FILTER_VALID_EMAIL))
							  {
								    $error["$ruleKey"] = "O campo {$ruleKey} deve conter um e-mail válido.";
							  }
							break;
					  }
				}
		  } // check datakey and ruleKey
	} // foreach data
  } // make
} // Validator