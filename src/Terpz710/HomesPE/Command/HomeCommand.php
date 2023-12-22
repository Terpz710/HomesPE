<?php

declare(strict_types=1);

namespace Terpz710\HomesPE\Command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\utils\Config;
use pocketmine\world\Position;

class HomeCommand extends Command {

    /** @var Plugin */
    private $plugin;

    public function __construct(Plugin $plugin) {
        parent::__construct(
            "home",
            "Teleport to home",
            "/home [home]",
            ["homes", "myhomes"]
        );
        $this->setPermission("homespe.home");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if ($sender instanceof Player) {
            if ($sender->hasPermission("homespe.home")) {
                $playerName = $sender->getName();
                $playerConfig = new Config($this->plugin->getDataFolder() . "Homes" . DIRECTORY_SEPARATOR . "$playerName.json", Config::JSON);

                $playerHomes = $playerConfig->get("homes", []);

                if (empty($playerHomes)) {
                    $sender->sendMessage("§c§lYou haven't set any homes. Use §e/sethome [HomeName]§c to set a home");
                    return true;
                }

                if (empty($args)) {
                    $homeList = implode("§f,§a ", array_keys($playerHomes));
                    $sender->sendMessage("§l§aYour homes§f:§a {$homeList}");
                    $sender->sendMessage("§eUse §l§a/home [home]§e to teleport to a specific home.");
                    return true;
                }

                $homeName = strtolower($args[0]);
                if (isset($playerHomes[$homeName])) {
                    $homeData = $playerHomes[$homeName];
                    $worldName = $homeData["world"];
                    $x = $homeData["x"];
                    $y = $homeData["y"];
                    $z = $homeData["z"];

                    $worldManager = $this->plugin->getServer()->getWorldManager();

                    if (!$worldManager->isWorldLoaded($worldName) && !$worldManager->loadWorld($worldName)) {
                        return false;
                    }

                    $world = $worldManager->getWorldByName($worldName);
                    if ($world === null) {
                        return false;
                    }

                    $position = new Position($x, $y, $z, $world);
                    $sender->teleport($position);
                    $sender->sendMessage("§l§aTeleported to home §e{$homeName}");
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
