<?php

  namespace ips;

  use pocketmine\plugin\PluginBase;
  use pocketmine\utils\Config;
  use pocketmine\command\CommandExecutor;

  class Main extends PluginBase implements CommandExecutor
  {
    public $cfg;
    public function onEnable()
    {
      @mkdir($this->getDataFolder());
      $this->cfg = new Config($this->getDataFolder() . 'ips.yml', Config::YAML);
      $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
      $this->getServer()->getCommandMap()->register('ips', new IPsCommand($this));
      $this->getLogger()->info('Enabled.');
    }

    public function onDisable()
    {
      $this->getLogger()->info('Disabled.');
    }
  }
