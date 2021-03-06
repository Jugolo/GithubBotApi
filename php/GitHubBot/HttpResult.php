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
    
    //handle Transfer-Encoding: chunked
    if(!empty($this->head["Transfer-Encoding"]) && $this->head["Transfer-Encoding"] == "chunked")
      return $this->chunk($socket);
    
    if(!empty($this->head["Content-Length"]))
      return fread($socket, intval($this->head["Content-Length"]));
    
    //okay let us push all wee can in a variabel
    $buffer = "";
    while($line = fgets($socket)){
      $buffer .= $line;
    }
    
    return $buffer;
  }
  
  private function chunk($socket){
    $return = "";
    while(!feof($socket)){
      $length = hexdec(fgets($socket));
      $return .= fread($socket, $length);
    }
    return $return;
  }
}
