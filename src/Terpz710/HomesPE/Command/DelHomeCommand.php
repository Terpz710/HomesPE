<?php

declare(strict_types=1);

namespace Terpz710\HomesPE\Command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\utils\Config;

class DelHomeCommand extends Command {

    /** @var Plugin */
    private $plugin;

    public function __construct(Plugin $plugin) {
        parent::__construct("deletehome", "Delete a home", null, ["delhome"]);
        $this->plugin = $plugin;
        $this->setPermission("homespe.delhome");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if ($sender instanceof Player) {
            if ($sender->hasPermission("homespe.delhome")) {
                $homeName = strtolower($args[0] ?? "default");
                $playerName = $sender->getName();

                $playerConfig = new Config($this->plugin->getDataFolder() . "Homes" . DIRECTORY_SEPARATOR . "$playerName.json", Config::JSON);

                $playerHomes = $playerConfig->get("homes", []);

                if (isset($playerHomes[$homeName])) {
                    unset($playerHomes[$homeName]);

                    $playerConfig->set("homes", $playerHomes);
                    $playerConfig->save();

                    $sender->sendMessage("§l§eHome §c{$homeName}§e deleted");
                } else {
                    $sender->sendMessage("§c§lHome §e{$homeName}§c not found. Use §e/home§c to see your available homes");
                }
            } else {
                $sender->sendMessage("§c§lYou don't have permission to use this command");
            }
        } else {
            $sender->sendMessage("This command can only be used by players.");
        }

        return true;
    }
}
