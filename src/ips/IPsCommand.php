<?php

  namespace ips;

  use pocketmine\command\Command;
  use pocketmine\command\CommandSender;
  use pocketmine\command\defaults\VanillaCommand;
  use pocketmine\utils\TextFormat;

  class IPsCommand extends VanillaCommand
  {
    private $plugin;
    public function __construct(Main $plugin)
    {
      parent::__construct('ips', 'view a list of IPs a player has used.', '/ips <player>');
      $this->setPermission('ips.command.ips');
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

    public function execute(CommandSender $sender, $alias, array $args)
    {
      if(!($this->testPermission($sender)))
      {
        return true;
      }
      if(count($args) === 0)
      {
        $sender->sendMessage(TextFormat::RED . 'Usage: /ips <player>');
        return true;
      }
      $player = array_shift($args);
      $player = $this->getPlugin()->getServer()->getPlayer($player);
      if(!($this->getCfg()->exists(strtolower($player->getName()))))
      {
        $sender->sendMessage(TextFormat::RED . $player->getName . 'hasn\'t joined yet.');
        return true;
      }
      $ips = $this->getCfg()->get(strtolower($player->getName()));
      $pips = '';
      foreach($ips as $ip)
      {
        if($ips[count($ips) - 1] !== $ip)
        {
          $pips .= $ip . ', ';
        }
        else
        {
          $pips .= $ip;
        }
      }
      $sender->sendMessage(TextFormat::GREEN . $player->getName() . '\'s list of IPs: ' . $pips);
      return true;
    }
  }
