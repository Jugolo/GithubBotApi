<?php
namespace GithubBot\EventBuilder;

use GithubBot\BotConfig\BotConfig;

class EventBuilder{
  private $config;
  private $arg = [];

  public function __construct(BotConfig $config){
    $this->config = $config;
  }

  public function setArg(string $name, string $value){
    if(in_array($name, ["username", "password", "repo"])){
      throw new \Exception("The arg '".$name."' is reserved and can not be used");
    }
    $this->arg[$name] = $value;
  }

  public function hasArg(string $name) : bool{
    return in_array($name, $this->arg);
  }

  public function getArg(string $name) : string{
    if(!$this->hasArg($name)){
      throw new \Exception("Has no arg '".$name."'");
    }
    return $this->arg[$name];
  }

  public function request(string $event){

  }
}
