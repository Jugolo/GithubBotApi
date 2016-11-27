<?php
namespace GitHubBot\GitHubBot;

use GithubBot\BotConfig\BotConfig;

class GitHubBot{
  private $config;

  /**
  *Set config to be used when it try to connect to cowscript server
  */
  public function setConfig(BotConfig $config){
    $this->config = $config;
  }

  /**
  *Get config for the bot.
  *@throw Exception if the config not yet is set
  *@return BotConfig
  */
  public function getConfig() : BotConfig{
    if($this->config == null){
      throw new \Exception("Missing bot config. Please use setConfig before getConfig");
    }
    return $this->config;
  }

  /**
  *Start buildning event 
  *@throw Exception when config is not yet set
  *@return EventBuilder
  */
  public function getBuilder() : EventBuilder{
    return new EventBuilder($this->getConfig());
  }
}
