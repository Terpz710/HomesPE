<?php

declare(strict_types=1);

namespace Terpz710\HomesPE;

use pocketmine\plugin\PluginBase;

use Terpz710\HomesPE\Command\HomeCommand;
use Terpz710\HomesPE\Command\SetHomeCommand;
use Terpz710\HomesPE\Command\DelHomeCommand;
use Terpz710\HomesPE\Command\HomesCommand;

class Main extends PluginBase {

    public function onEnable(): void {
        if (!is_dir($this->getDataFolder() . "Homes")) {
            @mkdir($this->getDataFolder() . "Homes");
        }

        $this->registerCommands();
    }

    private function registerCommands(): void {
        $this->getServer()->getCommandMap()->register("home", new HomeCommand($this));
        $this->getServer()->getCommandMap()->register("homes", new HomesCommand($this));
        $this->getServer()->getCommandMap()->register("delhome", new DelHomeCommand($this));
        $this->getServer()->getCommandMap()->register("sethome", new SetHomeCommand($this));
    }
}
