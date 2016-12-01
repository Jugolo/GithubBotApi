<?php
namespace GitHub\HttpResult;

class HttpResult{
  public $status;
  public $head = [];
  
  public function __construct($socket){
    while($line = fgets($socket)){
      if($line == "")
        break;
      if(strpos($line, "HTTP/1.1") === 0){
        list($type, $status, $ok) = explode(" ", $line);
        $this->status = $status;
        continue;
      }
      
      $pos = strpos($line, ":");
      $this->head[substr($line, 0, $pos)] = substr($line, $pos+2);
    }
  }
}
