<?php
namespace GitHubBot\Http;

class Http{
  private $information = [
    "ssl"    => false,
    "host"   => null,
    "port"   => 80,
    "path"   => "/",
    "method" => "GET",
    "posts"  => [],
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
    
    if(($pos = strpos($url, "/")) !== false){
      $host = substr($url, 0, $pos);
      $this->information["path"] = substr($url, $pos);
      if(($pos = strpos($host, ":")) !== false){
        $this->information["host"] = substr($host, 0, $pos);
        $this->information["port"] = intval(substr($host, $pos+1));
      }else{
        $this->information["host"] = $host;
      }
    }elseif(($pos = strpos($url, "?")) !== false){
      $host = substr($url, 0, $pos);
      $this->information["path"] = substr($url, $pos);
      if(($pos = strpos($host, ":")) !== false){
        $this->information["host"] = substr($host, 0, $pos);
        $this->information["port"] = intval(substr($host, $pos+1));
      }else{
        $this->information["host"] = $host;
      }
    }else{
      $this->information["host"] = $url;
    }
  }
  
  public function MultiPost(array $post){
    foreach($post as $key => $value){
      $this->post($key, $value);
    }
  }
  
  public function post(string $key, string $value){
    if($this->information["method"] !== "POST"){
      $this->information["method"] = "POST";
    }
    
    $this->information["posts"][$key] = $value;
  }
  
  public function exec() : HttpResult{
    $host = ($this->information["ssl"] ? "ssl://" : "").$this->information["host"];
    $socket = fsockopen($host, $this->information["port"]);
    if(!$socket)
      throw new \Exception("Could not connect to the url");
    
    $request = [
      $this->information["method"]." ".$this->information["path"]." HTTP/1.1",
      "Host: ".$this->information["host"]
    ];
  }
}
