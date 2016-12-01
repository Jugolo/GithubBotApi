<?php
namespace GitHub\HttpResult;

class HttpResult{
  public $status;
  
  public function __construct($socket){
    while($line = fgets($socket)){
      if($line == "")
        break;
      
      
    }
  }
}
