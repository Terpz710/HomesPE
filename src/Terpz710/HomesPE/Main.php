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
        if (!is_dir($this->getDataFolder() . "Homes")) {
            @mkdir($this->getDataFolder() . "Homes");
        }

        $config = new Config($this->getDataFolder() . "Homes" . DIRECTORY_SEPARATOR . "homes.json", Config::JSON);

        $this->getServer()->getCommandMap()->register("home", new HomeCommand($config, $this));
        $this->getServer()->getCommandMap()->register("homes", new HomesCommand($config, $this));
        $this->getServer()->getCommandMap()->register("delhome", new DelHomeCommand($config, $this));
        $this->getServer()->getCommandMap()->register("sethome", new SetHomeCommand($config, $this));
    }
}
