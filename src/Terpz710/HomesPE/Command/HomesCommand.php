<?php

declare(strict_types=1);

namespace Terpz710\HomesPE\Command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\utils\Config;

class HomesCommand extends Command {

    /** @var Plugin */
    private $plugin;

    public function __construct(Plugin $plugin) {
        parent::__construct("homes", "List your homes", "/homes", ["listhomes"]);
        $this->plugin = $plugin;
        $this->setPermission("homespe.homes");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if ($sender instanceof Player) {
            if ($sender->hasPermission("homespe.homes")) {
                $playerName = $sender->getName();
                $playerConfig = new Config($this->plugin->getDataFolder() . "Homes" . DIRECTORY_SEPARATOR . "$playerName.json", Config::JSON);

                $playerHomes = $playerConfig->get("homes", []);

                if (empty($playerHomes)) {
                    $sender->sendMessage("§c§lYou haven't set any homes. Use §e/sethome [HomeName]§c to set a home");
                } else {
                    $homeList = implode("§f,§a ", array_keys($playerHomes));
                    $sender->sendMessage("§l§aYour homes§f:§a {$homeList}");
                    $sender->sendMessage("§eUse §l§a/home [home]§e to teleport to a specific home.");
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
