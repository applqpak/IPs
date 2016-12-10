<?php

  namespace ips;

  use pocketmine\event\Listener;
  use pocketmine\event\player\PlayerJoinEvent;

  class EventListener implements Listener
  {
    private $plugin;
    public function __construct(Main $plugin)
    {
      $this->plugin = $plugin;
    }

    private function getPlugin()
    {
      return $this->plugin;
    }

    private function getCfg()
    {
      return $this->plugin->cfg;
    }

    public function onPlayerJoin(PlayerJoinEvent $ev)
    {
      $player = $ev->getPlayer();
      $ip = $player->getAddress();
      if($this->getCfg()->exists(strtolower($player->getName())))
      {
        $ips = $this->getCfg()->get(strtolower($player->getName()));
        if(!(in_array($ip, $ips)))
        {
          array_push($ip, $ips);
          $this->getCfg()->set(strtolower($player->getName()), $ips);
          $this->getCfg()->save();
        }
      }
      else
      {
        $this->getCfg()->set(strtolower($player->getName(), [$ip]));
        $this->getCfg()->save();
      }
    }
  }
