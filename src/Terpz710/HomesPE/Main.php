<?php

declare(strict_types=1);

namespace Terpz710\HubPE;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

use Terpz710\HubPE\command\HubCommand;
use Terpz710\HubPE\command\SetHubCommand;
use Terpz710\HubPE\command\DeleteHubCommand;

class Main extends PluginBase {

    public function onEnable(): void {
        if (!is_dir($this->getDataFolder() . "Hub")) {
            @mkdir($this->getDataFolder() . "Hub");
        }

        $config = new Config($this->getDataFolder() . "Hub" . DIRECTORY_SEPARATOR . "hub-data.json", Config::JSON);

        $this->getServer()->getCommandMap()->register("hub", new HubCommand($config, $this));
        $this->getServer()->getCommandMap()->register("sethub", new SetHubCommand($config, $this));
        $this->getServer()->getCommandMap()->register("deletehub", new DeleteHubCommand($config, $this));
    }
}
