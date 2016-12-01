<?php
namespace GitHubBot\Http;

class Http{
  private $information = [
    "ssl"  => false,
    "host" => null,
    "port" => 80,
    "path" => "/"
  ];
  
  public function __construct(string $url){
    if(($pos = strpos($url, "://")) !== false){
      if(substr($url, 0, $pos) == "https"){
        $this->information["ssl"] = true;
      }
      $url = substr($url, $pos+3);
    }
    
    if(strpos($url, "www.") === 0){
      $url = substr($url, 4);
    }
  }
}
