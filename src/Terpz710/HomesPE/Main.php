<?php

declare(strict_types=1);

namespace Terpz710\HomesPE;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

use Terpz710\HomesPE\Command\HomeCommand;
use Terpz710\HomesPE\Command\SetHomeCommand;
use Terpz710\HomesPE\Command\DelHomeCommand;
use Terpz710\HomesPE\Command\HomesCommand;

class Main extends PluginBase {

    public function onEnable(): void {
        $this->saveDefaultConfig();
        $config = new Config($this->getDataFolder() . "config.yml", Config::YAML);

        $this->getServer()->getCommandMap()->register("home", new HomeCommand($config, $this));
        $this->getServer()->getCommandMap()->register("homes", new HomesCommand($config, $this));
        $this->getServer()->getCommandMap()->register("delhome", new DelHomeCommand($config, $this));
        $this->getServer()->getCommandMap()->register("sethome", new SetHomeCommand($config, $this));
    }
}
